import os
import httpx
from dotenv import load_dotenv
from openai import OpenAI

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

mensagens = [
    {
        "role": "system",
        "content": "Você é um assistente claro, direto e didático. Responda sempre em português."
    }
]

print("Chatbot iniciado. Digite 'sair' para encerrar.")

while True:
    pergunta = input("Você: ").strip()

    if pergunta.lower() == "sair":
        print("Bot: Até mais!")
        break

    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    resposta = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=mensagens
    )

    resposta_texto = resposta.choices[0].message.content
    mensagens.append({"role": "assistant", "content": resposta_texto})

    print("Bot:", resposta_texto)