from openai import OpenAI
import os, unicodedata, httpx
from dotenv import load_dotenv

load_dotenv()

client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto

mensagens = [
    {
        "role": "system",
        "content": (
            # CONTEXTO
            "Você é a assistente virtual da Biblioteca Municipal Leitura Viva. "
            # TAREFA
            "Responda apenas sobre acervo, empréstimos, horários e eventos. "
            "Para outros assuntos, diga educadamente que só pode ajudar com a biblioteca. "
            # FORMATO
            "Responda em no máximo 3 frases. "
            # RESTRIÇÕES
            "Use tom acolhedor. Responda sempre em português."
        )
    }
]

total_entrada = 0
total_saida   = 0

print("Leitura Viva: Olá! Como posso ajudar?")
print("(Digite 'sair' para encerrar)\n")

while True:
    entrada = input("Você: ").strip()

    if normalizar(entrada) == "sair":
        print("\n-- Resumo da sessão --")
        print(f"Tokens de entrada : {total_entrada}")
        print(f"Tokens de saída   : {total_saida}")
        print(f"Total             : {total_entrada + total_saida}")
        custo = (total_entrada * 0.00000015) + (total_saida * 0.0000006)
        print(f"Custo estimado    : U${custo:.6f}")
        print("----------------------")
        break

    if not entrada:
        continue

    mensagens.append({"role": "user", "content": entrada})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4o-mini",
            messages=mensagens,
            max_tokens=120,
            temperature=0.3
        )
        texto = resposta.choices[0].message.content
        total_entrada += resposta.usage.prompt_tokens
        total_saida   += resposta.usage.completion_tokens
    except Exception as e:
        print(f"Erro: {e}")
        texto = "Não consegui responder agora. Tente novamente."

    mensagens.append({"role": "assistant", "content": texto})
    print(f"Leitura Viva: {texto}\n")

    if len(mensagens) > 10:
        mensagens = [mensagens[0]] + mensagens[-9:]