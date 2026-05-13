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
        "content": """Você é o assistente virtual de suporte técnico da TechFix.
Responda apenas perguntas sobre problemas de computador, internet,
impressora e celular. Se a pergunta não tiver relação com suporte
técnico, diga educadamente que só pode ajudar com esse assunto.
Use linguagem simples, sem termos técnicos difíceis.
Responda sempre em português."""
    }
]

print("TechFix: Olá! Como posso ajudar com seu problema técnico?")
print("(Digite 'sair' para encerrar)\n")

while True:
    pergunta = input("Você: ").strip()

    if pergunta.lower() == "sair":
        print("TechFix: Obrigado pelo contato! Até mais 👋")
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

    print(f"TechFix: {resposta_texto}\n")