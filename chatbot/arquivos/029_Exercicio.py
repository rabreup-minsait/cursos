from openai import OpenAI
import os
from dotenv import load_dotenv
import httpx

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

# Respostas fixas - não gastam tokens
respostas_fixas = {
    "horario":    "FitClub: Funcionamos de segunda a sábado, das 6h às 22h.",
    "horário":    "FitClub: Funcionamos de segunda a sábado, das 6h às 22h.",
    "preco":      "FitClub: Mensalidade básica R$89 e plano completo R$149.",
    "preço":      "FitClub: Mensalidade básica R$89 e plano completo R$149.",
    "mensalidade":"FitClub: Mensalidade básica R$89 e plano completo R$149.",
    "endereco":   "FitClub: Estamos na Rua das Palmeiras, 220 - Centro.",
    "endereço":   "FitClub: Estamos na Rua das Palmeiras, 220 - Centro.",
}

mensagens = [
    {
        "role": "system",
        "content": (
            "Você é o assistente virtual da FitClub, academia de musculação e ginástica. "
            "Responda dúvidas sobre treinos, modalidades e dicas de saúde. "
            "Use linguagem motivadora. Responda em no máximo 3 frases."
        )
    }
]

print("FitClub: Olá! Como posso ajudar? 💪")
print("(Digite 'sair' para encerrar)\n")

while True:
    pergunta = input("Você: ").strip()

    if pergunta.lower() == "sair":
        print("FitClub: Bons treinos! 🏋️")
        break
    if not pergunta:
        continue

    # Verifica se alguma palavra-chave está na pergunta
    resposta_fixa = None
    for chave in respostas_fixas:
        if chave in pergunta.lower():
            resposta_fixa = respostas_fixas[chave]
            break

    if resposta_fixa:
        print(f"{resposta_fixa}\n")
    else:
        mensagens.append({"role": "user", "content": pergunta})
        try:
            resposta = client.chat.completions.create(
                model="gpt-4o-mini",
                messages=mensagens,
                max_tokens=120,
                temperature=0.6
            )
            texto = resposta.choices[0].message.content
        except Exception as e:
            print(f"Erro: {e}")
            texto = "Não consegui responder agora. Tente novamente."

        mensagens.append({"role": "assistant", "content": texto})
        print(f"FitClub: {texto}\n")

        if len(mensagens) > 10:
            mensagens = [mensagens[0]] + mensagens[-9:]