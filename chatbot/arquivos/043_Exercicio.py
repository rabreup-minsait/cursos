import warnings
import urllib3
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

# variável controlada pelo código, fora do loop
nome = None

mensagens = [
    {
        "role": "system",
        "content": "Você é um assistente direto e objetivo. Responda de forma curta e clara."
    }
]

print("Chatbot iniciado. Digite 'sair' para encerrar.\n")

while True:
    pergunta = input("Você: ").strip()
    pergunta_norm = pergunta.lower()

    if pergunta_norm == "sair":
        print("Bot: Até mais!")
        break

    if not pergunta:
        continue

    # detecta nome na frase
    if "meu nome é" in pergunta_norm:
        nome = pergunta.split("meu nome é")[-1].strip().title()
        if not nome:
            nome = pergunta_norm.split("meu nome é")[-1].strip().title()
        print(f"Bot: Prazer, {nome}!")
        continue

    # injeta o nome no system prompt antes de chamar a IA
    if nome:
        mensagens[0]["content"] = (
            f"Você é um assistente direto e objetivo. "
            f"O nome do usuário é {nome}. Use o nome dele com moderação. "
            f"Responda de forma curta e clara."
        )

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