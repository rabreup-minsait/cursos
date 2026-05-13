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
    "Você é um assistente de suporte técnico de uma empresa de internet. "
    "Responda sempre em português, de forma clara e acessível. "
    "Se a pergunta não for sobre suporte técnico, diga educadamente que não pode ajudar."
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
            "perfil": {"nome": None, "gostos": []},
            "mensagens": [{"role": "system", "content": TEMA}]
        }
    return usuarios[user_id]
def montar_system(perfil: dict) -> str:
    contexto = TEMA
    if perfil["nome"]:
        contexto += f" O nome do usuário é {perfil['nome']}."
    if perfil["gostos"]:
        contexto += f" O usuário informou que gosta de: {', '.join(perfil['gostos'])}."
    return contexto
class Pergunta(BaseModel):
    texto: str
    user_id: str | None = "default"
@app.get("/")
def raiz():
    return {"mensagem": "API com tema e separação de usuários!"}
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
        return {"resposta": f"Prazer, {nome}!"}
    if "eu gosto de" in texto_norm:
        gosto = pegar_depois(texto_usuario, texto_norm, "eu gosto de").lower()
        gosto_norm = normalizar(gosto)
        gostos_salvos = [normalizar(g) for g in perfil["gostos"]]
        if gosto_norm not in gostos_salvos:
            perfil["gostos"].append(gosto)
            return {"resposta": f"Anotado! Você gosta de {gosto}."}
        return {"resposta": f"Sei que você gosta de {gosto}!"}
    mensagens[0]["content"] = montar_system(perfil)
    mensagens.append({"role": "user", "content": texto_usuario})
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=120,
            temperature=0.3
        )
        texto = resp.choices[0].message.content
    except Exception:
        texto = "Serviço temporariamente indisponível."
    mensagens.append({"role": "assistant", "content": texto})
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]
    usuario["mensagens"] = mensagens
    return {"resposta": texto}