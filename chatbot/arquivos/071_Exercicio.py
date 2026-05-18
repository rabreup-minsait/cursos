import logging
import os
from dotenv import load_dotenv
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from openai import OpenAI
from pydantic import BaseModel
import config_071
load_dotenv(override=True)
FAQ = {
    "horario": "A Livraria Aurora atende de segunda a sábado, das 10h às 20h.",
    "endereco": "A Livraria Aurora fica na Rua do Livro, 45, Centro.",
    "entrega": "A entrega é feita em até 5 dias úteis para a região metropolitana.",
}
PRODUTOS = {
    "livro de python": {
        "nome": "Livro de Python",
        "preco": "R$ 79,90",
        "estoque": 10,
    },
    "planner semanal": {
        "nome": "Planner Semanal",
        "preco": "R$ 39,90",
        "estoque": 18,
    },
    "marca texto": {
        "nome": "Marca Texto",
        "preco": "R$ 6,90",
        "estoque": 50,
    },
}
logging.basicConfig(
    filename=config_071.LOG_ARQUIVO,
    level=logging.INFO,
    format="%(asctime)s | %(levelname)s | %(message)s",
    encoding="utf-8",
)
client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))
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
def buscar_faq(texto):
    for palavra, resposta in FAQ.items():
        if palavra in texto:
            return resposta
    return None
def buscar_produto(texto):
    for chave, produto in PRODUTOS.items():
        if chave in texto:
            return produto
    return None
def parece_produto(texto):
    gatilhos = [
        "preco",
        "valor",
        "tem",
        "produto",
        "estoque",
        "comprar",
        "livro",
        "planner",
        "marca texto",
        ]
    return any(gatilho in texto for gatilho in gatilhos)
def responder_com_ia(texto):
    resposta = client.chat.completions.create(
        model=config_071.MODELO,
        messages=[
            {"role": "system", "content": config_071.SYSTEM_BASE},
            {"role": "user", "content": texto},
        ],
        temperature=config_071.TEMPERATURA,
        max_tokens=config_071.MAX_TOKENS,
    )
    return resposta.choices[0].message.content
@app.get("/")
def raiz():
    return {"mensagem": f"{config_071.NOME_BOT} no ar"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    try:
        texto = normalizar(pergunta.texto)
        logging.info("REQUISICAO | usuario=%s | pergunta=%s", pergunta.user_id, pergunta.texto)
        resposta_faq = buscar_faq(texto)
        if resposta_faq:
            logging.info("ORIGEM | faq")
            return {"origem": "faq", "resposta": resposta_faq}
        if parece_produto(texto):
            produto = buscar_produto(texto)
            if not produto:
                logging.warning("PRODUTO_FORA_CATALOGO | usuario=%s", pergunta.user_id)
                return {
                    "origem": "trava_de_escopo",
                    "resposta": "Esse produto não está cadastrado na Livraria Aurora.",
                }
            logging.info("ORIGEM | produto | %s", produto["nome"])
            return {
                "origem": "produto_cadastrado",
                "resposta": (
                    f"{produto['nome']} custa {produto['preco']} "
                    f"e temos {produto['estoque']} unidades em estoque."
                ),
            }
        logging.info("ORIGEM | ia")
        return {"origem": "ia", "resposta": responder_com_ia(pergunta.texto)}
    except Exception as erro:
        logging.error("ERRO | %s", erro, exc_info=True)
        return {
            "origem": "erro",
            "resposta": "Não consegui processar sua mensagem agora.",
        }