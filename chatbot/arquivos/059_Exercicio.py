import warnings
import urllib3
import unicodedata
import httpx
import os
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from openai import OpenAI
from dotenv import load_dotenv
warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv()
app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)
client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)
TEMA = (
    "Você é um assistente de atendimento do Restaurante Bella Vista. "
    "Ajude com cardápio, reservas, horários e dúvidas sobre o restaurante. "
    "Responda de forma cordial e objetiva. "
    "Se a pergunta não for sobre o restaurante, diga educadamente que não pode ajudar com esse assunto."
)
usuarios: dict = {}
def normalizar(texto: str) -> str:
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(
        c for c in texto
        if unicodedata.category(c) != "Mn"
    )
def pegar_depois(texto_original: str, texto_normalizado: str, marcador: str) -> str:
    posicao = texto_normalizado.find(marcador)
    if posicao == -1:
        return ""
    inicio = posicao + len(marcador)
    return texto_original[inicio:].strip(".,!?:;")
def obter_usuario(user_id: str) -> dict:
    if user_id not in usuarios:
        usuarios[user_id] = {
            "perfil": {"nome": None, "preferencias": []},
            "mensagens": [{"role": "system", "content": TEMA}]
        }
    return usuarios[user_id]
def montar_system(perfil: dict) -> str:
    contexto = TEMA
    if perfil["nome"]:
        contexto += f" O cliente se chama {perfil['nome']}."
    if perfil["preferencias"]:
        contexto += f" Preferências do cliente: {', '.join(perfil['preferencias'])}."
    return contexto
class Pergunta(BaseModel):
    texto: str
    user_id: str | None = "default"
@app.get("/")
def raiz():
    return {"mensagem": "Restaurante Bella Vista no ar!"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    uid = (pergunta.user_id or "default").strip() or "default"
    usuario = obter_usuario(uid)
    perfil = usuario["perfil"]
    mensagens = usuario["mensagens"]
    texto_usuario = pergunta.texto.strip()
    texto_norm = normalizar(texto_usuario)
    if not texto_usuario:
        return {"resposta": ""}
    if "meu nome e" in texto_norm:
        nome = pegar_depois(texto_usuario, texto_norm, "meu nome e").title()
        perfil["nome"] = nome
        return {
            "resposta": f"Que prazer receber você, {nome}! Posso ajudar com o cardápio ou uma reserva?"
        }
    if "eu gosto de" in texto_norm:
        preferencia = pegar_depois(texto_usuario, texto_norm, "eu gosto de").lower()
        pref_norm = normalizar(preferencia)
        preferencias_salvas = [normalizar(p) for p in perfil["preferencias"]]
        if pref_norm not in preferencias_salvas:
            perfil["preferencias"].append(preferencia)
            return {"resposta": f"Anotei sua preferência por {preferencia}."}
        return {"resposta": f"Sim, eu já tenho anotado que você gosta de {preferencia}."}
    mensagens[0]["content"] = montar_system(perfil)
    mensagens.append({"role": "user", "content": texto_usuario})
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=120,
            temperature=0.4
        )
        texto = resp.choices[0].message.content
    except Exception:
        texto = "Desculpe, tive um problema. Pode repetir?"
    mensagens.append({"role": "assistant", "content": texto})
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]
    usuario["mensagens"] = mensagens
    return {"resposta": texto}