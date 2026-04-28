import warnings
import urllib3
import json
import os
import httpx
from dotenv import load_dotenv
from openai import OpenAI

warnings.filterwarnings("ignore")
urllib3.disable_warnings()
load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

ARQUIVO_MEMORIA = "memoria.json"

def carregar_memoria():
    if os.path.exists(ARQUIVO_MEMORIA):
        try:
            with open(ARQUIVO_MEMORIA, "r", encoding="utf-8") as f:
                return json.load(f)
        except (json.JSONDecodeError, ValueError):
            pass
    return [{"role": "system", "content": "Você é um assistente direto, objetivo e claro."}]

def salvar_memoria(mensagens):
    with open(ARQUIVO_MEMORIA, "w", encoding="utf-8") as f:
        json.dump(mensagens, f, ensure_ascii=False, indent=2)

mensagens = carregar_memoria()

print("Chatbot com memória iniciado. Digite 'sair' para encerrar.")

while True:
    pergunta = input("Você: ").strip()
    if pergunta.lower() == "sair":
        print("Bot: Até mais!")
        break
    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    resposta = client.chat.completions.create(
        model="gpt-4.1-mini",
        messages=mensagens,
        max_tokens=80,
        temperature=0.2,
        frequency_penalty=0.4,
        presence_penalty=0.2
    )

    texto = resposta.choices[0].message.content
    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto)
    salvar_memoria(mensagens)