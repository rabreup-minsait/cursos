from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import config_069
app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)
class Pergunta(BaseModel):
    texto: str
    user_id: str = "default"
def normalizar(texto):
    return texto.lower().strip()
def buscar_resposta(texto):
    texto = normalizar(texto)
    for palavra, resposta in config_069.FAQ_CLINICA.items():
        if palavra in texto:
            return resposta
    return config_069.RESPOSTA_PADRAO
@app.get("/")
def raiz():
    return {"mensagem": f"{config_069.NOME_BOT} no ar"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    return {
        "origem": "faq_configurado",
        "resposta": buscar_resposta(pergunta.texto),
    }