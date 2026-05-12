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

# perfil controlado pelo código
nome    = None
generos = []   # gêneros literários preferidos

LIMITE_MSG   = 10
ULTIMAS_MSG  = 5
total_entrada = 0
total_saida   = 0

def atualizar_system():
    # CONTEXTO
    base = "Você é a assistente virtual da Livraria Páginas, especializada em recomendar livros."
    # TAREFA
    if nome and generos:
        lista = ", ".join(generos)
        perfil = f"Atenda {nome} pelo nome. O cliente prefere: {lista}. Personalize as sugestões."
    elif nome:
        perfil = f"Atenda {nome} pelo nome com moderação."
    elif generos:
        lista = ", ".join(generos)
        perfil = f"O cliente prefere: {lista}. Use isso nas sugestões."
    else:
        perfil = "Atenda o cliente de forma acolhedora."
    # FORMATO + RESTRIÇÕES
    regras = (
        "Responda em no máximo 3 frases. "
        "Fale apenas sobre livros, autores e a livraria. "
        "Se não souber algo, diga claramente que não sabe. "
        "Nunca invente títulos, autores ou preços."
    )
    mensagens[0]["content"] = " ".join([base, perfil, regras])

def resumir_conversa(msgs_antigas):
    texto = "\n".join([f"{m['role']}: {m['content']}" for m in msgs_antigas])
    r = client.chat.completions.create(
        model="gpt-4.1-mini",
        messages=[
            {"role": "system", "content": "Resuma a conversa abaixo em 1 frase curta."},
            {"role": "user", "content": texto}
        ],
        max_tokens=50, temperature=0.2
    )
    return r.choices[0].message.content

def limpar_memoria():
    global nome, generos, mensagens, total_entrada, total_saida
    nome = None
    generos = []
    total_entrada = 0
    total_saida   = 0
    mensagens = [{"role": "system", "content": ""}]
    atualizar_system()
    print("Livraria Páginas: Sessão reiniciada! Como posso ajudar?")

mensagens = [{"role": "system", "content": ""}]
atualizar_system()

print("Livraria Páginas: Olá! Seja bem-vindo. Como posso ajudar?")
print("(Digite 'limpar' para nova sessão ou 'sair' para encerrar)\n")

while True:
    pergunta = input("Você: ").strip()
    pn = normalizar(pergunta)

    if pn == "sair":
        print("\n-- Resumo da sessão --")
        print(f"Tokens de entrada : {total_entrada}")
        print(f"Tokens de saída   : {total_saida}")
        print(f"Total             : {total_entrada + total_saida}")
        custo = (total_entrada * 0.00000015) + (total_saida * 0.0000006)
        print(f"Custo estimado    : U${custo:.6f}")
        print("Livraria Páginas: Até a próxima leitura!")
        break

    if pn == "limpar":
        limpar_memoria()
        continue

    if not pergunta:
        continue

    if "meu nome e" in pn:
        nome = pergunta.split("meu nome é")[-1].strip().title()
        atualizar_system()
        print(f"Livraria Páginas: Que bom te ver, {nome}!")
        continue

    if "eu gosto de" in pn or "prefiro" in pn:
        divisor = "eu gosto de" if "eu gosto de" in pn else "prefiro"
        genero = pergunta.lower().split(divisor)[-1].strip()
        gnorm = normalizar(genero)
        if gnorm not in [normalizar(g) for g in generos]:
            generos.append(genero)
            atualizar_system()
            print(f"Livraria Páginas: Ótimo! Tenho ótimas sugestões de {genero}.")
        else:
            print(f"Livraria Páginas: Já sei que você curte {genero}!")
        continue

    # memória resumida
    if len(mensagens) > LIMITE_MSG:
        antigas = mensagens[1:-ULTIMAS_MSG]
        if antigas:
            resumo = resumir_conversa(antigas)
            mensagens = [
                mensagens[0],
                {"role": "system", "content": f"Resumo anterior: {resumo}"}
            ] + mensagens[-ULTIMAS_MSG:]

    mensagens.append({"role": "user", "content": pergunta})

    try:
        resp = client.chat.completions.create(
            model="gpt-4.1-mini",
            messages=mensagens,
            max_tokens=100,
            temperature=0.4
        )
        texto = resp.choices[0].message.content
        total_entrada += resp.usage.prompt_tokens
        total_saida   += resp.usage.completion_tokens
    except Exception as e:
        texto = "Não consegui processar. Tente novamente."

    mensagens.append({"role": "assistant", "content": texto})
    print(f"Livraria Páginas: {texto}\n")