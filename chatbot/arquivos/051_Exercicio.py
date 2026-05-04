import warnings
import urllib3
import httpx
import os
from fastapi import FastAPI
from pydantic import BaseModel
from openai import OpenAI
from dotenv import load_dotenv
import uvicorn
warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv()
app = FastAPI()
client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)
class Mensagem(BaseModel):
    texto: str
@app.post("/chat")
def chat(msg: Mensagem):
    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": "Você é um assistente direto e objetivo."},
                {"role": "user", "content": msg.texto}
            ],
            max_tokens=150,
            temperature=0.4
        )
        return {"resposta": resposta.choices[0].message.content}
    except Exception as e:
        return {"resposta": "Não consegui processar. Tente novamente.", "erro": str(e)}
if __name__ == "__main__":
    uvicorn.run("051_Exercicio:app", host="0.0.0.0", port=8000, reload=True)