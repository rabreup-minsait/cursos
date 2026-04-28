from openai import OpenAI
import os
from dotenv import load_dotenv
import httpx
import tiktoken

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

enc = tiktoken.encoding_for_model("gpt-4o-mini")
LIMITE_TOKENS = 80

modos = {
    "informativo": {
        "system": (
            "Você é o assistente da LinguaViva, escola de inglês e espanhol. "
            "Responda apenas dúvidas sobre cursos, preços, horários e matrículas. "
            "Use tom profissional. Responda em até 3 frases objetivas."
        ),
        "temperature": 0.2,
        "max_tokens": 150
    },
    "conversacional": {
        "system": (
            "You are a friendly English conversation partner at LinguaViva school. "
            "Help students practice English. Keep it simple and encouraging. "
            "Respond in English, max 2 short sentences."
        ),
        "temperature": 0.8,
        "max_tokens": 100
    }
}

print("Modos disponíveis: informativo | conversacional")
escolha = input("Escolha o modo: ").strip().lower()

if escolha not in modos:
    print("Modo inválido. Usando 'informativo' como padrão.")
    escolha = "informativo"

config = modos[escolha]
mensagens = [{"role": "system", "content": config["system"]}]

total_entrada = 0
total_saida   = 0

print(f"\nLinguaViva ({escolha}): Olá! Como posso ajudar?\n")

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

    # Bloqueia mensagens longas antes de gastar tokens
    tokens_pergunta = len(enc.encode(pergunta))
    if tokens_pergunta > LIMITE_TOKENS:
        print(f"LinguaViva: Mensagem muito longa ({tokens_pergunta} tokens). Por favor, escreva de forma mais curta.\n")
        continue

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4o-mini",
            messages=mensagens,
            temperature=config["temperature"],
            max_tokens=config["max_tokens"]
        )
        texto = resposta.choices[0].message.content
        total_entrada += resposta.usage.prompt_tokens
        total_saida   += resposta.usage.completion_tokens
    except Exception as e:
        print(f"Erro: {e}")
        texto = "Não foi possível responder agora. Tente novamente."

    mensagens.append({"role": "assistant", "content": texto})
    print(f"LinguaViva: {texto}\n")

    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]