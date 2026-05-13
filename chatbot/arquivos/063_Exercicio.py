import warnings, urllib3, unicodedata, httpx, os
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from openai import OpenAI
from dotenv import load_dotenv
warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv()
app = FastAPI()
app.add_middleware(CORSMiddleware, allow_origins=["*"], allow_methods=["*"], allow_headers=["*"])
client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"), http_client=httpx.Client(verify=False))
PRODUTOS = {
    "notebook pro":    {"preco": "R$ 4.500", "estoque": "disponivel", "descricao": "16GB RAM, SSD 512GB"},
    "mouse sem fio":   {"preco": "R$ 120",   "estoque": "disponivel", "descricao": "Ergonomico 2.4GHz"},
    "teclado mecanico":{"preco": "R$ 350",   "estoque": "esgotado",   "descricao": "Switch azul"},
    "monitor 24":      {"preco": "R$ 1.200",  "estoque": "disponivel", "descricao": "Full HD 24 pol"},
}
SYSTEM_BASE = (
    "Voce e o assistente da TechShop. "
    "Responda sempre em portugues, de forma clara e amigavel. "
    "Se nao tiver certeza de uma informacao, diga que nao sabe, nunca invente."
)
usuarios: dict = {}
def normalizar(texto: str) -> str:
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(c for c in texto if unicodedata.category(c) != "Mn")
def pegar_depois(texto_original: str, texto_normalizado: str, marcador: str) -> str:
    posicao = texto_normalizado.find(marcador)
    if posicao == -1:
        return ""
    inicio = posicao + len(marcador)
    return texto_original[inicio:].strip(".,!?:; ")
def obter_usuario(uid: str) -> dict:
    if uid not in usuarios:
        usuarios[uid] = {
            "perfil": {"nome": None},
            "mensagens": [{"role": "system", "content": SYSTEM_BASE}]
        }
    return usuarios[uid]
def classificar(texto: str) -> str:
    t = normalizar(texto)
    if any(g in t for g in ["meu nome", "eu me chamo", "quem eu sou"]):
        return "dados_usuario"
    if any(g in t for g in ["preco", "valor", "custa", "estoque", "disponivel",
                                        "notebook", "mouse", "teclado", "monitor"]):
        return "busca_produto"
    return "conversa"
def buscar_produto(texto: str) -> str:
    t = normalizar(texto)
    encontrados = [
        f"{nome.title()}: {d['preco']}, {d['estoque']}, {d['descricao']}"
        for nome, d in PRODUTOS.items()
        if any(p in t for p in normalizar(nome).split())
    ]
    return "\n".join(encontrados) if encontrados else "Produto nao encontrado no catalogo."
class Pergunta(BaseModel):
    texto: str
    user_id: str | None = "default"
@app.get("/")
def raiz(): return {"mensagem": "TechShop API no ar!"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    uid = (pergunta.user_id or "default").strip()
    usuario = obter_usuario(uid)
    perfil = usuario["perfil"]
    mensagens = usuario["mensagens"]
    texto_usuario = pergunta.texto.strip()
    if not texto_usuario: return {"resposta": ""}
    categoria = classificar(texto_usuario)
    # caminho 1: dados do usuario
    if categoria == "dados_usuario":
        t = normalizar(texto_usuario)
        if "meu nome e" in t:
            nome = pegar_depois(texto_usuario, t, "meu nome e").title()
            perfil["nome"] = nome
            return {"resposta": f"Prazer, {nome}! Como posso ajudar?"}
        if "quem eu sou" in t:
            return {"resposta": f"Voce e {perfil['nome']}." if perfil["nome"] else "Ainda nao sei seu nome."}
    # caminho 2: busca de produto com dados reais
    if categoria == "busca_produto":
        dados = buscar_produto(texto_usuario)
        prompt_produto = (
            f"{SYSTEM_BASE} Responda usando APENAS as informacoes abaixo. "
            "Se a informacao nao estiver nos dados, diga que nao tem essa informacao.\n\n"
            f"Dados disponiveis:\n{dados}"
        )
        try:
            resp = client.chat.completions.create(
                model="gpt-4.1-mini",
                messages=[{"role": "system", "content": prompt_produto},
                           {"role": "user", "content": texto_usuario}],
                max_tokens=100, temperature=0.1
            )
            return {"resposta": resp.choices[0].message.content}
        except Exception:
            return {"resposta": "Nao consegui consultar o catalogo agora."}
    # caminho 3: conversa livre com historico
    ctx = SYSTEM_BASE
    if perfil["nome"]: ctx += f" O cliente se chama {perfil['nome']}."
    mensagens[0]["content"] = ctx
    mensagens.append({"role": "user", "content": texto_usuario})
    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini", messages=mensagens, max_tokens=100, temperature=0.4
        )
        texto = resp.choices[0].message.content
    except Exception:
        texto = "Servico temporariamente indisponivel."
    mensagens.append({"role": "assistant", "content": texto})
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]
    usuario["mensagens"] = mensagens
    return {"resposta": texto}