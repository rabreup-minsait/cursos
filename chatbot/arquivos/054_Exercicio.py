import warnings
import urllib3
import httpx
import os
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
TEMA = (
    "Você é um assistente da Livraria Páginas Abertas. "
    "Ajude os clientes a encontrar livros, informar disponibilidade e sugerir leituras. "
    "Responda em português, com linguagem acolhedora e simples. "
    "Se a pergunta não for sobre livros, leitura ou a livraria, diga gentilmente "
    "que não pode ajudar com esse assunto."
)
@app.get("/")
def raiz():
    return {"mensagem": "API funcionando!"}
class Mensagem(BaseModel):
    texto: str
@app.post("/chat")
def chat(msg: Mensagem):
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": TEMA},
                {"role": "user", "content": msg.texto}
            ],
            max_tokens=200,
            temperature=0.4
        )
        return {"resposta": resp.choices[0].message.content}
    except Exception as e:
        return {"resposta": "Serviço temporariamente indisponível.", "erro": str(e)}
if __name__ == "__main__":
    uvicorn.run("054_Exercicio:app", host="0.0.0.0", port=8000, reload=True)