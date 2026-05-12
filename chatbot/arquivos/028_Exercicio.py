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
            # CONTEXTO
            "Você é a assistente virtual da MiauWoof, pet shop especializada em cães e gatos. "
            # TAREFA
            "Responda apenas sobre produtos, serviços de banho e tosa, e cuidados com pets. "
            "Para assuntos fora desse escopo, diga que só entende de pets. "
            # FORMATO
            "Responda em no máximo 2 frases. "
            # RESTRIÇÕES
            "Use tom carinhoso e divertido. Responda sempre em português."
        )
    }
]

total_entrada = 0
total_saida   = 0

print("MiauWoof: Olá! Como posso ajudar seu pet hoje? 🐾")
print("(Digite 'sair' para encerrar)\n")

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
        print("MiauWoof: Volte sempre! 🐾")
        break

    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4o-mini",
            messages=mensagens,
            max_tokens=80,
            temperature=0.6,
            frequency_penalty=0.3
        )
        texto = resposta.choices[0].message.content
        total_entrada += resposta.usage.prompt_tokens
        total_saida   += resposta.usage.completion_tokens

    except Exception as e:
        print(f"Erro: {e}")
        texto = "Não consegui processar sua pergunta. Tente novamente."

    mensagens.append({"role": "assistant", "content": texto})
    print(f"MiauWoof: {texto}\n")

    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]