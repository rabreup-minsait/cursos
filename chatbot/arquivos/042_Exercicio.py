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

LIMITE_MENSAGENS = 8
ULTIMAS_MENSAGENS = 4

nome_cliente = input("Sabor & Arte: Olá! Qual é o seu nome? ").strip()

mensagens = [
    {
        "role": "system",
        "content": (
            f"Você é o assistente virtual do restaurante Sabor & Arte. "
            f"O cliente se chama {nome_cliente}. Use o nome dele ocasionalmente para personalizar. "
            "Responda apenas sobre cardápio, reservas e horários. "
            "Use linguagem acolhedora. Responda em no máximo 3 frases. "
            "Para assuntos fora do escopo, redirecione gentilmente."
        )
    }
]

total_entrada = 0
total_saida   = 0

def resumir_conversa(mensagens_antigas):
    texto = "\n".join([f"{m['role']}: {m['content']}" for m in mensagens_antigas])
    r = client.chat.completions.create(
        model="gpt-4.1-mini",
        messages=[
            {"role": "system", "content": "Resuma a conversa abaixo em no máximo 1 frase."},
            {"role": "user", "content": texto}
        ],
        max_tokens=50, temperature=0.2
    )
    return r.choices[0].message.content

print(f"\nSabor & Arte: Que bom ter você aqui, {nome_cliente}! Como posso ajudar?")
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
        print(f"Sabor & Arte: Até logo, {nome_cliente}! Volte sempre!")
        break

    if not pergunta:
        continue

    mensagens.append({"role": "user", "content": pergunta})

    if len(mensagens) > LIMITE_MENSAGENS:
        antigas = mensagens[1:-ULTIMAS_MENSAGENS]
        if antigas:
            resumo = resumir_conversa(antigas)
            mensagens = [
                mensagens[0],
                {"role": "system", "content": f"Resumo anterior: {resumo}"}
            ] + mensagens[-ULTIMAS_MENSAGENS:]

    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=100,
            temperature=0.4
        )
        texto = resposta.choices[0].message.content
        total_entrada += resposta.usage.prompt_tokens
        total_saida   += resposta.usage.completion_tokens
    except Exception as e:
        print(f"Erro: {e}")
        texto = "Não consegui processar. Tente novamente."

    mensagens.append({"role": "assistant", "content": texto})
    print(f"Sabor & Arte: {texto}\n")