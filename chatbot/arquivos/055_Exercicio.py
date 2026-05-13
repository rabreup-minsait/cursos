import warnings
import urllib3
import httpx
import os
import unicodedata
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from openai import OpenAI
from dotenv import load_dotenv
import uvicorn
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
nome_usuario = None
def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(
        caractere
        for caractere in texto
        if unicodedata.category(caractere) != "Mn"
    )
def extrair_nome(texto_original):
    texto_normalizado = normalizar(texto_original)
    marcador = "meu nome e"
    if marcador not in texto_normalizado:
        return None
    inicio = texto_normalizado.find(marcador) + len(marcador)
    nome = texto_original[inicio:].strip()
    nome = nome.split(".")[0].split(",")[0].strip()
    if not nome:
        return None
    return nome.title()
def montar_system():
    base = (
        "Você é um assistente da Livraria Páginas Abertas. "
        "Ajude com recomendações e informações sobre livros. "
        "Se a pergunta não for sobre livros ou sobre a livraria, diga que não pode "
        "ajudar com esse assunto. Seja claro, acolhedor e conciso."
    )
    if nome_usuario:
        base += f" O nome do cliente é {nome_usuario}. Use o nome com moderação."
    return base
class Mensagem(BaseModel):
    texto: str
@app.post("/chat")
def chat(msg: Mensagem):
    global nome_usuario
    nome_detectado = extrair_nome(msg.texto)
    if nome_detectado:
        nome_usuario = nome_detectado
        return {
            "resposta": (
                f"Prazer, {nome_usuario}. Vou lembrar do seu nome enquanto "
                "o servidor estiver ligado."
            )
        }
    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": montar_system()},
                {"role": "user", "content": msg.texto}
            ],
            max_tokens=200,
            temperature=0.4
        )
        return {"resposta": resposta.choices[0].message.content}
    except Exception as e:
        return {
            "resposta": "Serviço temporariamente indisponível.",
            "erro": str(e)
        }
if __name__ == "__main__":
    uvicorn.run("055_Exercicio:app", host="0.0.0.0", port=8000, reload=True)