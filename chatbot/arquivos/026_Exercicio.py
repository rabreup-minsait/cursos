from openai import OpenAI
import os
from dotenv import load_dotenv
import httpx

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

modos = {
    "criativo": {
        "system": "Você é um assistente criativo e expressivo. Use metáforas, exemplos coloridos e linguagem envolvente.",
        "temperature": 1.2,
        "max_tokens": 300,
        "top_p": 0.95
    },
    "tecnico": {
        "system": "Você é um assistente técnico e preciso. Dê explicações detalhadas com exemplos práticos quando necessário.",
        "temperature": 0.2,
        "max_tokens": 500,
        "top_p": 0.8
    },
    "economico": {
        "system": "Você é um assistente direto e objetivo. Responda em no máximo 2 frases curtas. Sem enrolação.",
        "temperature": 0.2,
        "max_tokens": 80,
        "frequency_penalty": 0.4
    }
}

print("Modos disponíveis: criativo | tecnico | economico")
escolha = input("Escolha o modo: ").strip().lower()

if escolha not in modos:
    print("Modo inválido. Usando 'tecnico' como padrão.")
    escolha = "tecnico"

config = modos[escolha]
mensagens = [{"role": "system", "content": config["system"]}]

print(f"\nModo '{escolha}' ativado. Digite 'sair' para encerrar.\n")

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
        messages=mensagens,
        temperature=config["temperature"],
        max_tokens=config["max_tokens"],
        top_p=config.get("top_p", 1.0),
        frequency_penalty=config.get("frequency_penalty", 0.0)
    )

    texto = resposta.choices[0].message.content
    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto, "\n")

    # Limita o histórico para controlar o custo
    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]