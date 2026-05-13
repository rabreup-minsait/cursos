from openai import OpenAI
import os
from dotenv import load_dotenv
import httpx

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

mensagens = [
    {
        "role": "system",
        "content": (
            "Você é um assistente direto e objetivo. "
            "Responda de forma curta, clara e sem enrolação. "
            "Evite repetir palavras e frases. "
            "Seja eficiente e econômico nas respostas."
        )
    }
]

total_entrada = 0
total_saida   = 0

print("Chatbot iniciado. Digite 'sair' para encerrar.\n")

while True:
    pergunta = input("Você: ").strip()

    if pergunta.lower() == "sair":
        print("\n-- Resumo da sessão --")
        print(f"Tokens de entrada : {total_entrada}")
        print(f"Tokens de saída   : {total_saida}")
        print(f"Total             : {total_entrada + total_saida}")
        custo = (total_entrada * 0.00000015) + (total_saida * 0.0000006)
        print(f"Custo estimado    : U${custo:.6f}")
        print("----------------------")
        break

    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4o-mini",
            messages=mensagens,
            max_tokens=80,
            temperature=0.2,
            frequency_penalty=0.4,
            presence_penalty=0.2
        )
        texto = resposta.choices[0].message.content
        total_entrada += resposta.usage.prompt_tokens
        total_saida   += resposta.usage.completion_tokens

    except Exception as e:
        print(f"Erro na API: {e}")
        texto = "Desculpe, houve um erro ao processar sua mensagem."

    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto, "\n")

    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]