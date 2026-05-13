import warnings, urllib3, unicodedata, httpx, os
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from openai import OpenAI
from dotenv import load_dotenv
warnings.filterwarnings("ignore"); urllib3.disable_warnings(); load_dotenv()
app = FastAPI()
app.add_middleware(CORSMiddleware, allow_origins=["*"], allow_methods=["*"], allow_headers=["*"])
client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"), http_client=httpx.Client(verify=False))
FAQ = {
    "horario|abre|fecha|funciona":    "Atendemos seg-sex 9h-18h e sab 9h-13h.",
    "endereco|localizacao|onde fica": "Rua das Flores, 123, Centro.",
    "pagamento|cartao|pix|parcelar":  "PIX, credito ate 12x e dinheiro.",
    "troca|devolucao|devolver":       "30 dias para troca com nota fiscal.",
    "entrega|frete|envio|prazo":      "Frete gratis acima de R$150. Prazo 3-7 dias.",
    "contato|whatsapp|telefone":     "WhatsApp: (11) 99999-9999",
}
SYSTEM_BASE = "Voce e o assistente da TechShop. Responda de forma clara. Se nao souber, encaminhe para atendente."
usuarios: dict = {}
def normalizar(t: str) -> str:
    t = unicodedata.normalize("NFD", t.lower())
    return "".join(c for c in t if unicodedata.category(c) != "Mn")
def buscar_faq(texto: str) -> str | None:
    t = normalizar(texto)
    for chaves, resp in FAQ.items():
        if any(k in t for k in chaves.split("|")): return resp
    return None
def obter_usuario(uid: str) -> dict:
    if uid not in usuarios:
        usuarios[uid] = {"perfil": {"nome": None}, "mensagens": [{"role": "system", "content": SYSTEM_BASE}]}
    return usuarios[uid]
class Pergunta(BaseModel):
    texto: str; user_id: str | None = "default"
@app.get("/")
def raiz(): return {"mensagem": "TechShop FAQ no ar!"}
@app.post("/chat")
def chat(pergunta: Pergunta):
    uid = (pergunta.user_id or "default").strip()
    u = obter_usuario(uid)
    texto_usuario = pergunta.texto.strip()
    if not texto_usuario: return {"resposta": ""}
    t = normalizar(texto_usuario)
    if "meu nome e" in t:
        nome = texto_usuario.split("meu nome e")[-1].strip().title()
        u["perfil"]["nome"] = nome
        return {"resposta": f"Prazer, {nome}! Como posso ajudar?"}
    # FAQ primeiro, sem acionar a IA
    faq = buscar_faq(texto_usuario)
    if faq: return {"resposta": faq}
    # so chega aqui se o FAQ nao tinha resposta
    msgs = u["mensagens"]
    ctx = SYSTEM_BASE
    if u["perfil"]["nome"]: ctx += f" O cliente se chama {u['perfil']['nome']}."
    msgs[0]["content"] = ctx
    msgs.append({"role": "user", "content": texto_usuario})
    try:
        r = client.chat.completions.create(
            model="gpt-4.1-mini", messages=msgs, max_tokens=100, temperature=0.4
        )
        texto = r.choices[0].message.content
    except Exception:
        texto = "Servico indisponivel."
    msgs.append({"role": "assistant", "content": texto})
    if len(msgs) > 10: msgs = [msgs[0]] + msgs[-9:]
    u["mensagens"] = msgs
    return {"resposta": texto}