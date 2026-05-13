import warnings
import urllib3
import unicodedata
import httpx
from dotenv import load_dotenv
from openai import OpenAI
import os

warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto

nome = None
gostos = []  # lista de gostos controlada pelo código

mensagens = [
    {
        "role": "system",
        "content": "Você é um assistente direto e objetivo. Responda de forma curta e clara."
    }
]

def atualizar_system():
    """Reconstrói o system prompt com as informações atuais."""
    partes = ["Você é um assistente direto e objetivo."]
    if nome:
        partes.append(f"O nome do usuário é {nome}. Use o nome com moderação.")
    if gostos:
        lista_gostos = ", ".join(gostos)
        partes.append(f"O usuário gosta de: {lista_gostos}.")
    partes.append("Responda de forma curta e clara.")
    mensagens[0]["content"] = " ".join(partes)

print("Chatbot iniciado. Digite 'sair' para encerrar.\n")

while True:
    pergunta = input("Você: ").strip()
    pergunta_norm = normalizar(pergunta)

    if pergunta_norm == "sair":
        print("Bot: Até mais!")
        break

    if not pergunta:
        continue

    # detecta nome
    if "meu nome e" in pergunta_norm:
        nome = pergunta.split("meu nome é")[-1].strip().title()
        atualizar_system()
        print(f"Bot: Prazer, {nome}!")
        continue

    # detecta gosto e evita duplicidade
    if "eu gosto de" in pergunta_norm:
        gosto_bruto = pergunta.lower().split("eu gosto de")[-1].strip()
        gosto_norm = normalizar(gosto_bruto)
        if gosto_norm not in [normalizar(g) for g in gostos]:
            gostos.append(gosto_bruto)
            atualizar_system()
            print(f"Bot: Anotado! Você gosta de {gosto_bruto}.")
        else:
            print(f"Bot: Já sei que você gosta de {gosto_bruto}!")
        continue

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=80,
            temperature=0.3
        )
        texto = resposta.choices[0].message.content
    except Exception as e:
        texto = "Desculpe, houve um erro."

    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto, "\n")