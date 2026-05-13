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
SYSTEM_BASE = (
    "Contexto: você é a assistente virtual da Casa Fácil Imóveis. "
    "Tarefa: atender pessoas interessadas em imóveis, usando dados reais quando houver. "
    "Formato: responda em português, com frases curtas e claras. "
    "Restrições: nunca invente preço, endereço, disponibilidade ou condição de pagamento. "
    "Se não houver informação suficiente, diga que não tem essa informação e ofereça encaminhar para um atendente."
)
FAQ = {
    "horario|abre|fecha|funciona": "Atendemos de segunda a sexta das 9h às 18h e aos sábados das 9h às 13h.",
    "endereco|localizacao|onde fica": "Nossa unidade fica na Rua das Flores, 123, Centro.",
    "financiamento|financiar|entrada": "Trabalhamos com simulação de financiamento, mas a aprovação depende da análise do banco.",
    "visita|agendar|agenda": "Para agendar uma visita, informe o imóvel desejado, o melhor dia e o melhor horário.",
    "documentos|documentacao": "Para iniciar uma proposta, normalmente são solicitados RG, CPF, comprovante de renda e comprovante de residência.",
}
IMOVEIS = {
    "apartamento centro": {
        "tipo": "apartamento",
        "bairro": "Centro",
        "preco": "R$ 420.000",
        "quartos": 2,
        "status": "disponível",
        "descricao": "Apartamento próximo ao metrô, com varanda e uma vaga."
    },
    "casa jardim": {
        "tipo": "casa",
        "bairro": "Jardim Europa",
        "preco": "R$ 780.000",
        "quartos": 3,
        "status": "disponível",
        "descricao": "Casa térrea com quintal, suíte e duas vagas."
    },
    "studio paulista": {
        "tipo": "studio",
        "bairro": "Paulista",
        "preco": "R$ 310.000",
        "quartos": 1,
        "status": "reservado",
        "descricao": "Studio compacto, mobiliado e próximo a comércios."
    },
    "sobrado vila": {
        "tipo": "sobrado",
        "bairro": "Vila Mariana",
        "preco": "R$ 950.000",
        "quartos": 4,
        "status": "disponível",
        "descricao": "Sobrado amplo, com escritório e área gourmet."
    },
}
usuarios: dict = {}
def normalizar(texto: str) -> str:
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(
        c for c in texto
        if unicodedata.category(c) != "Mn"
    )
def pegar_depois(texto_original: str, texto_normalizado: str, marcador: str) -> str:
    posicao = texto_normalizado.find(marcador)
    if posicao == -1:
        return ""
    inicio = posicao + len(marcador)
    return texto_original[inicio:].strip(".,!?:; ")
def obter_usuario(user_id: str) -> dict:
    if user_id not in usuarios:
        usuarios[user_id] = {
            "perfil": {
                "nome": None,
                "cidade": None
            },
            "mensagens": [
                {"role": "system", "content": SYSTEM_BASE}
            ]
        }
    return usuarios[user_id]
def buscar_faq(texto: str) -> str | None:
    texto_norm = normalizar(texto)
    for chaves, resposta in FAQ.items():
        palavras = chaves.split("|")
        if any(palavra in texto_norm for palavra in palavras):
            return resposta
    return None
def buscar_imovel(texto: str) -> str:
    texto_norm = normalizar(texto)
    encontrados = []
    for nome, dados in IMOVEIS.items():
        palavras_nome = normalizar(nome).split()
        palavras_tipo = normalizar(dados["tipo"]).split()
        palavras_bairro = normalizar(dados["bairro"]).split()
        palavras_busca = palavras_nome + palavras_tipo + palavras_bairro
        if any(palavra in texto_norm for palavra in palavras_busca):
            encontrados.append(
                f"{nome.title()}: {dados['tipo']}, bairro {dados['bairro']}, "
                f"{dados['preco']}, {dados['quartos']} quarto(s), "
                f"{dados['status']}. {dados['descricao']}"
            )
    if encontrados:
        return "\n".join(encontrados)
    return ""
def classificar(texto: str) -> str:
    texto_norm = normalizar(texto)
    if any(p in texto_norm for p in ["meu nome", "eu me chamo", "minha cidade", "moro em"]):
        return "dados_usuario"
    if buscar_faq(texto):
        return "faq"
    palavras_imovel = [
        "apartamento", "casa", "studio", "sobrado", "imovel",
        "preco", "valor", "quartos", "bairro", "disponivel",
        "centro", "jardim", "paulista", "vila"
    ]
    if any(p in texto_norm for p in palavras_imovel):
        return "busca_imovel"
    return "conversa"
class Pergunta(BaseModel):
    texto: str
    user_id: str | None = "default"
class LimparRequest(BaseModel):
    user_id: str
@app.get("/")
def raiz():
    return {"mensagem": "API da Casa Fácil Imóveis no ar!"}
@app.post("/limpar")
def limpar(req: LimparRequest):
    uid = req.user_id.strip()
    if uid in usuarios:
        del usuarios[uid]
        return {"mensagem": f"Memória do usuário {uid} apagada."}
    return {"mensagem": "Usuário não encontrado."}
@app.post("/chat")
def chat(pergunta: Pergunta):
    uid = (pergunta.user_id or "default").strip() or "default"
    usuario = obter_usuario(uid)
    perfil = usuario["perfil"]
    mensagens = usuario["mensagens"]
    texto_usuario = pergunta.texto.strip()
    texto_norm = normalizar(texto_usuario)
    if not texto_usuario:
        return {"resposta": ""}
    categoria = classificar(texto_usuario)
    if categoria == "dados_usuario":
        if "meu nome e" in texto_norm:
            nome = pegar_depois(texto_usuario, texto_norm, "meu nome e").title()
            perfil["nome"] = nome
            return {"resposta": f"Prazer, {nome}! Como posso ajudar?"}
        if "eu me chamo" in texto_norm:
            nome = pegar_depois(texto_usuario, texto_norm, "eu me chamo").title()
            perfil["nome"] = nome
            return {"resposta": f"Prazer, {nome}! Como posso ajudar?"}
        if "minha cidade e" in texto_norm:
            cidade = pegar_depois(texto_usuario, texto_norm, "minha cidade e").title()
            perfil["cidade"] = cidade
            return {"resposta": f"Perfeito. Vou considerar sua cidade como {cidade}."}
        if "moro em" in texto_norm:
            cidade = pegar_depois(texto_usuario, texto_norm, "moro em").title()
            perfil["cidade"] = cidade
            return {"resposta": f"Perfeito. Vou considerar sua cidade como {cidade}."}
    if categoria == "faq":
        return {"resposta": buscar_faq(texto_usuario)}
    if categoria == "busca_imovel":
        dados = buscar_imovel(texto_usuario)
        if dados:
            contexto = (
                f"{SYSTEM_BASE}\n\n"
                "Perfil do usuário:\n"
                f"Nome: {perfil['nome'] or 'não informado'}\n"
                f"Cidade: {perfil['cidade'] or 'não informada'}\n\n"
                "Dados de imóveis encontrados:\n"
                f"{dados}\n\n"
                "Use apenas esses dados para responder sobre preço, bairro, quartos, status e descrição."
            )
            temperatura = 0.2
        else:
            contexto = (
                f"{SYSTEM_BASE}\n\n"
                "Nenhum imóvel foi encontrado na base local. "
                "Não invente imóveis, preços ou endereços."
            )
            temperatura = 0.4
        try:
            resposta = client.chat.completions.create(
                model="gpt-4.1-mini",
                messages=[
                    {"role": "system", "content": contexto},
                    {"role": "user", "content": texto_usuario}
                ],
                max_tokens=140,
                temperature=temperatura
            )
            return {"resposta": resposta.choices[0].message.content}
        except Exception:
            return {"resposta": "Serviço temporariamente indisponível."}
    contexto = SYSTEM_BASE
    if perfil["nome"]:
        contexto += f" O usuário se chama {perfil['nome']}."
    if perfil["cidade"]:
        contexto += f" O usuário informou que mora em {perfil['cidade']}."
    mensagens[0]["content"] = contexto
    mensagens.append({"role": "user", "content": texto_usuario})
    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=120,
            temperature=0.4
        )
        texto = resposta.choices[0].message.content
    except Exception:
        texto = "Serviço temporariamente indisponível."
    mensagens.append({"role": "assistant", "content": texto})
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]
    usuario["mensagens"] = mensagens
    return {"resposta": texto}