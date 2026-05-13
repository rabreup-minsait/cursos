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
"Ajude clientes com recomendações de livros, dúvidas sobre gêneros literários "
"e informações gerais de atendimento da livraria. "
"Se a pergunta não tiver relação com livros ou com a livraria, explique com educação "
"que só pode ajudar nesse contexto. Use linguagem acolhedora, simples e objetiva."
)
class Mensagem(BaseModel):
    texto: str
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
    uvicorn.run("054_Exercicio:app", host="0.0.0.0", port=8000, reload=True)