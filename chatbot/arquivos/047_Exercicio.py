import warnings
import urllib3
import unicodedata
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

def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto

def extrair_gosto_via_ia(frase):
    """Usa o GPT para identificar se há uma preferência positiva na frase."""
    try:
        r = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=[
                {
                    "role": "system",
                    "content": (
                        "Analise a frase do usuário e responda APENAS com "
                        "a preferência positiva identificada (ex: sushi, pizza) "
                        "ou com a palavra NENHUMA se não houver preferência positiva. "
                        "Não inclua nenhum outro texto."
                    )
                },
                {"role": "user", "content": frase}
            ],
            max_tokens=20,
            temperature=0.1
        )
        resultado = r.choices[0].message.content.strip()
        return None if resultado.upper() == "NENHUMA" else resultado.lower()
    except:
        return None

nome   = None
gostos = []

mensagens = [
    {"role": "system", "content": "Você é um assistente direto e objetivo."}
]

def atualizar_system():
    if nome and gostos:
        lista = ", ".join(gostos)
        contexto = (
            f"Você é um assistente direto. O usuário se chama {nome} "
            f"e gosta de: {lista}. Use essas informações com moderação."
        )
    elif nome:
        contexto = f"Você é um assistente direto. O usuário se chama {nome}. Use o nome com moderação."
    elif gostos:
        lista = ", ".join(gostos)
        contexto = f"Você é um assistente direto. O usuário gosta de: {lista}."
    else:
        contexto = "Você é um assistente direto e objetivo. Responda de forma curta e clara."
    mensagens[0]["content"] = contexto

print("Chatbot iniciado. Digite 'sair' para encerrar.\n")

while True:
    pergunta = input("Você: ").strip()
    pergunta_norm = normalizar(pergunta)

    if pergunta_norm == "sair":
        print("Bot: Até mais!")
        break

    if not pergunta:
        continue

    if "meu nome e" in pergunta_norm:
        nome = pergunta.split("meu nome é")[-1].strip().title()
        atualizar_system()
        print(f"Bot: Prazer, {nome}!")
        continue

    # usa a IA para detectar se há um gosto na frase
    gosto_detectado = extrair_gosto_via_ia(pergunta)
    if gosto_detectado:
        gosto_norm = normalizar(gosto_detectado)
        if gosto_norm not in [normalizar(g) for g in gostos]:
            gostos.append(gosto_detectado)
            atualizar_system()
            print(f"Bot: Anotado que você gosta de {gosto_detectado}.")
        else:
            print(f"Bot: Já sei que você gosta de {gosto_detectado}!")
        continue

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resposta = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=80,
            temperature=0.3
        )
        texto = resposta.choices[0].message.content
    except Exception as e:
        texto = "Desculpe, houve um erro."

    mensagens.append({"role": "assistant", "content": texto})
    print("Bot:", texto, "\n")