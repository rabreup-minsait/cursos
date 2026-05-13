import warnings
import urllib3
import unicodedata
import httpx
import os
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
PRODUTOS = {
    "notebook pro": {
        "preco": "R$ 4.500",
        "estoque": "disponível",
        "descricao": "16GB RAM, SSD 512GB, indicado para estudo e programação"
    },
    "mouse sem fio": {
        "preco": "R$ 120",
        "estoque": "disponível",
        "descricao": "Mouse ergonômico 2.4GHz para uso diário"
    },
    "teclado mecanico": {
        "preco": "R$ 350",
        "estoque": "esgotado",
        "descricao": "Teclado com switch azul, indicado para digitação intensa"
    },
    "monitor 24": {
        "preco": "R$ 1.200",
        "estoque": "disponível",
        "descricao": "Monitor Full HD de 24 polegadas"
    },
}
SYSTEM_BASE = (
    "Você é o assistente da TechShop. "
    "Responda em português, com clareza e objetividade. "
    "Quando houver dados do catálogo, use esses dados como fonte principal. "
    "Nunca invente preço, estoque, prazo ou característica técnica."
)
def normalizar(texto: str) -> str:
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(
        c for c in texto
        if unicodedata.category(c) != "Mn"
    )
def buscar_produto(texto: str) -> str:
    texto_norm = normalizar(texto)
    encontrados = []
    for nome, dados in PRODUTOS.items():
        palavras_produto = normalizar(nome).split()
        if any(palavra in texto_norm for palavra in palavras_produto):
            encontrados.append(
                f"{nome.title()}: {dados['preco']}, "
                f"{dados['estoque']}, {dados['descricao']}"
            )
    if encontrados:
        return "\n".join(encontrados)
    return ""
def classificar(texto: str) -> str:
    texto_norm = normalizar(texto)
    palavras_produto = [
        "preco", "valor", "custa", "estoque", "disponivel",
        "notebook", "mouse", "teclado", "monitor"
    ]
    palavras_opiniao = [
        "melhor", "recomenda", "vale a pena", "indicado",
        "bom para", "qual escolher"
    ]
    tem_produto = any(p in texto_norm for p in palavras_produto)
    tem_opiniao = any(p in texto_norm for p in palavras_opiniao)
    if tem_produto and tem_opiniao:
        return "produto_com_opiniao"
    if tem_produto:
        return "produto"
    return "conversa"
class Pergunta(BaseModel):
    texto: str
@app.get("/")
def raiz():
    return {"mensagem": "API híbrida da TechShop no ar!"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    texto_usuario = pergunta.texto.strip()
    if not texto_usuario:
        return {"resposta": ""}
    categoria = classificar(texto_usuario)
    dados = buscar_produto(texto_usuario)
    if categoria in ["produto", "produto_com_opiniao"]:
        if dados:
            contexto = (
                f"{SYSTEM_BASE}\n\n"
                "Dados encontrados no catálogo:\n"
                f"{dados}\n\n"
                "Responda usando esses dados. "
                "Se a pergunta pedir recomendação, explique a recomendação com base nos dados encontrados."
            )
            temperatura = 0.2
        else:
            contexto = (
                f"{SYSTEM_BASE}\n\n"
                "Nenhum produto foi encontrado no catálogo. "
                "Responda de forma geral, sem inventar preço, estoque ou característica específica."
            )
            temperatura = 0.5
    else:
        contexto = SYSTEM_BASE
        temperatura = 0.4
    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {"role": "system", "content": contexto},
                {"role": "user", "content": texto_usuario}
            ],
            max_tokens=120,
            temperature=temperatura
        )
        texto = resposta.choices[0].message.content
    except Exception:
        texto = "Serviço temporariamente indisponível."
    return {
        "categoria": categoria,
        "dados_usados": dados if dados else None,
        "resposta": texto
    }