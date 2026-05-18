from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)
PRODUTOS = {
    "caderno universitario": {
        "nome": "Caderno Universitário",
        "preco": "R$ 24,90",
        "estoque": 30,
    },
    "caneta azul": {
        "nome": "Caneta Azul",
        "preco": "R$ 2,50",
        "estoque": 120,
    },
    "mochila escolar": {
        "nome": "Mochila Escolar",
        "preco": "R$ 89,90",
        "estoque": 12,
    },
}
class Pergunta(BaseModel):
    texto: str
    user_id: str = "default"
def normalizar(texto):
    return texto.lower().strip()
def buscar_produto(texto):
    texto = normalizar(texto)
    for chave, produto in PRODUTOS.items():
        if chave in texto:
            return produto
    return None
def nomes_cadastrados():
    return [produto["nome"] for produto in PRODUTOS.values()]
@app.get("/")
def raiz():
    return {"mensagem": "Consulta de produtos da Papelaria Ponto Certo"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    produto = buscar_produto(pergunta.texto)
    if not produto:
        cadastrados = ", ".join(nomes_cadastrados())
        return {
            "origem": "trava_de_escopo",
            "resposta": (
                "Esse produto não está cadastrado na Papelaria Ponto Certo. "
                f"Produtos disponíveis para consulta: {cadastrados}."
            ),
        }
    return {
        "origem": "produto_cadastrado",
        "resposta": (
            f"{produto['nome']} custa {produto['preco']} "
            f"e temos {produto['estoque']} unidades em estoque."
        ),
    }