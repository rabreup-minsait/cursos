import warnings
import urllib3
import json
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

prompt = """Me dê 3 livros clássicos da literatura brasileira.
Responda APENAS em JSON válido, sem nenhum texto fora do JSON.
Use exatamente esta estrutura:
{
  "livros": [
    {
      "titulo": "string",
      "autor": "string",
      "ano": número,
      "sinopse": "string com 1 frase",
      "disponivel_digitalmente": true ou false ou null
    }
  ]
}
Sem texto fora do JSON."""

resposta = client.chat.completions.create(
    model="gpt-4.1-mini",
    messages=[{"role": "user", "content": prompt}],
    temperature=0.2
)

texto = resposta.choices[0].message.content
texto = texto.strip().removeprefix("```json").removeprefix("```").removesuffix("```").strip()

try:
    dados = json.loads(texto)
    if "livros" not in dados:
        print("Campo 'livros' não encontrado no JSON.")
    else:
        for livro in dados["livros"]:
            print(f"Título: {livro['titulo']} ({livro['ano']})")
            print(f"Autor: {livro['autor']}")
            print(f"Sinopse: {livro['sinopse']}")
            print(f"Digital: {livro['disponivel_digitalmente']}")
            print("---")
except json.JSONDecodeError:
    print("JSON inválido. Resposta bruta:")
    print(texto)