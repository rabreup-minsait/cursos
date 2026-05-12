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
    "Você é um assistente de suporte técnico de uma empresa de internet. "
    "Responda sempre em português, de forma clara e acessível. "
    "Se a pergunta não for sobre suporte técnico, diga educadamente que não pode ajudar."
)
class Mensagem(BaseModel):
    texto: str
@app.get("/status")
def status():
    return {
        "chatbot": "Suporte Net Fácil",
        "status": "ativo",
        "mensagem": "API funcionando corretamente."
}
@app.post("/chat")
def chat(msg: Mensagem):
    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": TEMA},
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
    uvicorn.run("053_Exercicio:app", host="0.0.0.0", port=8000, reload=True)