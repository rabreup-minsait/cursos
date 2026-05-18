import os
import unicodedata
import warnings
import httpx
import urllib3
from dotenv import load_dotenv
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from openai import OpenAI
from pydantic import BaseModel
import config
from faq import buscar_faq
from produtos import buscar_produto, nomes_cadastrados, parece_pergunta_de_produto

warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv(override=True)

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(
        verify=config.SSL_VERIFY,
        timeout=config.TIMEOUT_API,
    ),
)

class Pergunta(BaseModel):
    texto: str
    user_id: str = "default"

def normalizar(texto):
    texto = texto.lower().strip()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(
        caractere
        for caractere in texto
        if unicodedata.category(caractere) != "Mn"
    )

def responder_com_ia(mensagem, contexto=None, temperatura=None):
    system_prompt = config.SYSTEM_BASE

    if contexto:
        system_prompt += f"\nUse somente estes dados para responder:\n{contexto}"

    resposta = client.chat.completions.create(
        model=config.MODELO,
        messages=[
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": mensagem},
        ],
        temperature=temperatura if temperatura is not None else config.TEMPERATURA_PADRAO,
        max_tokens=config.MAX_TOKENS,
    )

    return resposta.choices[0].message.content

@app.get("/")
def raiz():
    return {"mensagem": f"{config.NOME_BOT} no ar"}

@app.post("/chat")
def chat(pergunta: Pergunta):
    texto_original = pergunta.texto.strip()
    texto_normalizado = normalizar(texto_original)

    resposta_faq = buscar_faq(texto_normalizado)
    if resposta_faq:
        return {"origem": "faq", "resposta": resposta_faq}

    if parece_pergunta_de_produto(texto_normalizado):
        produto = buscar_produto(texto_normalizado)

        if not produto and config.EXIGIR_PRODUTO_CADASTRADO:
            if config.MOSTRAR_PRODUTOS_DISPONIVEIS:
                cadastrados = ", ".join(nomes_cadastrados())
                resposta = (
                    "Não encontrei esse produto no catálogo da TechShop. "
                    f"Hoje consigo consultar estes produtos: {cadastrados}."
                )
            else:
                resposta = "Não encontrei esse produto no catálogo da TechShop."

            return {"origem": "trava_de_escopo", "resposta": resposta}

        contexto = (
            f"Produto: {produto['nome']}\n"
            f"Preço: {produto['preco']}\n"
            f"Estoque: {produto['estoque']} unidades\n"
            f"Descrição: {produto['descricao']}"
        )

        return {
            "origem": "produto_cadastrado",
            "resposta": responder_com_ia(
                texto_original,
                contexto=contexto,
                temperatura=config.TEMPERATURA_DADOS,
            ),
        }

    return {
        "origem": "ia_geral",
        "resposta": responder_com_ia(texto_original),
    }