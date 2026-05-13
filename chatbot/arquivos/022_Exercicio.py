import os
import httpx
from dotenv import load_dotenv
from openai import OpenAI

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

print("Chatbot iniciado. Digite 'sair' para encerrar.")

while True:
    pergunta = input("Você: ").strip()

    if pergunta.lower() == "sair":
        break

    if not pergunta:
        continue

    resposta = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[{"role": "user", "content": pergunta}]
    )

    print("Bot:", resposta.choices[0].message.content)