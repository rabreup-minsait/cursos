import warnings
import urllib3
import unicodedata
import httpx
import os
import json
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
TEMA_BASE = (
    "Contexto: você é o assistente da Livraria Leitura Viva, especializada em literatura brasileira. "
    "Tarefa: ajude o cliente a encontrar livros, responda sobre o acervo e faça sugestões personalizadas. "
    "Formato: respostas em até 3 frases. Quando indicar um livro, responda apenas em JSON no formato "
    "{\"titulo\": str, \"autor\": str, \"motivo\": str}. Sem texto fora do JSON. "
    "Restrições: fale apenas sobre livros e a livraria. Nunca invente ISBNs ou prêmios."
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
            "perfil": {"nome": None, "generos": []},
            "mensagens": [{"role": "system", "content": TEMA_BASE}]
        }
    return usuarios[user_id]
def montar_system(perfil: dict) -> str:
    contexto = TEMA_BASE
    if perfil["nome"] and perfil["generos"]:
        generos = ", ".join(perfil["generos"])
        contexto += f" Atenda {perfil['nome']}, que gosta de: {generos}. Personalize as sugestões."
    elif perfil["nome"]:
        contexto += f" Atenda {perfil['nome']} com cordialidade."
    return contexto
def resposta_direta(texto_norm: str, perfil: dict) -> str | None:
    if "oi" in texto_norm or "ola" in texto_norm:
        nome = f", {perfil['nome']}" if perfil["nome"] else ""
        return f"Olá{nome}! Bem-vindo à Leitura Viva. Posso indicar um livro ou tirar dúvidas."
    if "tchau" in texto_norm or "ate logo" in texto_norm:
        return "Até a próxima! Boas leituras."
    return None
class Pergunta(BaseModel):
    texto: str
    user_id: str | None = "default"
class LimparRequest(BaseModel):
    user_id: str
@app.get("/")
def raiz():
    return {"mensagem": "Leitura Viva no ar!"}
@app.post("/limpar")
def limpar(req: LimparRequest):
    uid = req.user_id.strip()
    if uid in usuarios:
        del usuarios[uid]
        return {"mensagem": f"Memória de {uid} apagada."}
    return {"mensagem": "Usuário não encontrado."}
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
    direta = resposta_direta(texto_norm, perfil)
    if direta:
        return {"resposta": direta}
    if "meu nome e" in texto_norm:
        nome = pegar_depois(texto_usuario, texto_norm, "meu nome e").title()
        perfil["nome"] = nome
        return {"resposta": f"Prazer, {nome}! Qual tipo de leitura você curte?"}
    if "gosto de" in texto_norm:
        genero = pegar_depois(texto_usuario, texto_norm, "gosto de").lower()
        genero_norm = normalizar(genero)
        generos_salvos = [normalizar(g) for g in perfil["generos"]]
        if genero_norm not in generos_salvos:
            perfil["generos"].append(genero)
            return {"resposta": f"Anotei que você curte {genero}!"}
        return {"resposta": f"Sei que você curte {genero}!"}
    mensagens[0]["content"] = montar_system(perfil)
    mensagens.append({"role": "user", "content": texto_usuario})
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=150,
            temperature=0.4
        )
        raw = resp.choices[0].message.content.strip()
        try:
            dados = json.loads(raw)
            texto = f"Sugestão: {dados['titulo']} de {dados['autor']}. {dados['motivo']}"
        except (json.JSONDecodeError, KeyError):
            texto = raw
    except Exception:
        texto = "Desculpe, tive um problema. Pode repetir?"
    mensagens.append({"role": "assistant", "content": texto})
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]
    usuario["mensagens"] = mensagens
    return {"resposta": texto}