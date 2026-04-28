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

LIMITE_MENSAGENS = 10
ULTIMAS_MENSAGENS = 5

mensagens = [
    {
        "role": "system",
        "content": "Você é um assistente direto e objetivo. Responda de forma curta e clara."
    }
]

def resumir_conversa(mensagens_antigas):
    """Gera um resumo das mensagens antigas usando o GPT"""
    texto = "\n".join([f"{m['role']}: {m['content']}" for m in mensagens_antigas])
    resposta = client.chat.completions.create(
        model="gpt-4.1-mini",
        messages=[
            {"role": "system", "content": "Resuma a conversa abaixo em no máximo 1 frase curta."},
            {"role": "user", "content": texto}
        ],
        max_tokens=50,
        temperature=0.2
    )
    return resposta.choices[0].message.content

print("Chatbot iniciado. Digite 'sair' para encerrar.")

while True:
    pergunta = input("Você: ").strip()
    if pergunta.lower() == "sair":
        print("Bot: Até mais!")
        break
    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    # Se passou do limite, resumimos as mensagens mais antigas
    if len(mensagens) > LIMITE_MENSAGENS:
        antigas = mensagens[1:-ULTIMAS_MENSAGENS]
        if antigas:
            resumo = resumir_conversa(antigas)
            mensagens = [
                mensagens[0],
                {"role": "system", "content": f"Resumo da conversa anterior: {resumo}"}
            ] + mensagens[-ULTIMAS_MENSAGENS:]

    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=80,
            temperature=0.2,
            frequency_penalty=0.4,
            presence_penalty=0.2
        )
        texto = resposta.choices[0].message.content
    except Exception as e:
        print(f"Erro na API: {e}")
        texto = "Desculpe, houve um erro."

    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto)