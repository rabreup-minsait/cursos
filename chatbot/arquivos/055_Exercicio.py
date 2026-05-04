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
    return "".join(c for c in texto if unicodedata.category(c) != "Mn")
def montar_system():
    base = (
        "Você é um assistente da Livraria Páginas Abertas. "
        "Ajude com recomendações e informações sobre livros. "
        "Seja caloroso e conciso."
    )
    if nome_usuario:
        base += f" O nome do cliente é {nome_usuario}. Use o nome com moderação."
    return base
class Mensagem(BaseModel):
    texto: str
@app.post("/chat")
def chat(msg: Mensagem):
    global nome_usuario
    texto_original = msg.texto.strip()
    texto_norm = normalizar(texto_original)
    marcador = "meu nome e"
    if marcador in texto_norm:
        inicio = texto_norm.find(marcador) + len(marcador)
        nome_usuario = texto_original[inicio:].strip(" .,!?:;").title()
        return {"resposta": f"Prazer, {nome_usuario}! Como posso ajudar?"}
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": montar_system()},
                {"role": "user", "content": msg.texto}
            ],
            max_tokens=200,
            temperature=0.4
        )
        return {"resposta": resp.choices[0].message.content}
    except Exception as e:
        return {"resposta": "Serviço indisponível no momento.", "erro": str(e)}
if __name__ == "__main__":
    uvicorn.run("055_Exercicio:app", host="0.0.0.0", port=8000, reload=True)