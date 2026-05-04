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

nome   = None
gostos = []
cidade = None  # NOVO

mensagens = [
    {"role": "system", "content": "Você é um assistente direto e objetivo."}
]

def atualizar_system():
    if nome and gostos:
        lista = ", ".join(gostos)
        contexto = f"Você é um assistente direto. O usuário se chama {nome}"
        if cidade:  # NOVO
            contexto += f" e mora em {cidade}"
        contexto += f" e gosta de: {lista}. Use essas informações com moderação."
    elif nome:
        contexto = f"Você é um assistente direto. O usuário se chama {nome}"
        if cidade:  # NOVO
            contexto += f" e mora em {cidade}"
        contexto += ". Use o nome com moderação."
    elif gostos:
        lista = ", ".join(gostos)
        contexto = f"Você é um assistente direto. O usuário gosta de: {lista}."
    else:
        contexto = "Você é um assistente direto e objetivo. Responda de forma curta e clara."
    mensagens[0]["content"] = contexto

def limpar_memoria():
    global nome, gostos, mensagens, cidade  # NOVO: cidade incluída
    nome   = None
    gostos = []
    cidade = None  # NOVO
    mensagens = [
        {"role": "system", "content": "Você é um assistente direto e objetivo."}
    ]
    print("Bot: Memória limpa! Podemos começar de novo.")

print("Chatbot iniciado. Digite 'limpar' para zerar a memória ou 'sair' para encerrar.")

while True:
    pergunta = input("Você: ").strip()
    pergunta_norm = normalizar(pergunta)

    if pergunta_norm == "sair":
        print("Bot: Até mais!")
        break

    if pergunta_norm == "limpar":
        limpar_memoria()
        continue

    if not pergunta:
        continue

    if "meu nome e" in pergunta_norm:
        nome = pergunta.split("meu nome é")[-1].strip().title()
        atualizar_system()
        print(f"Bot: Prazer, {nome}!")
        continue

    if "moro em" in pergunta_norm:  # NOVO
        cidade = pergunta.lower().split("moro em")[-1].strip().title()
        atualizar_system()
        print(f"Bot: Entendido! Você mora em {cidade}.")
        continue

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