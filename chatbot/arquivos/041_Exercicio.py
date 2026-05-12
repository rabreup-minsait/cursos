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

prompt = """Me dê 3 séries brasileiras populares.
Responda APENAS em JSON válido, sem nenhum texto fora do JSON.
Use exatamente esta estrutura:
{
  "series": [
    {
      "titulo": "string",
      "genero": "string",
      "ano_estreia": número,
      "plataforma": "string",
      "sinopse": "string com 1 frase",
      "avaliacao_imdb": número ou null
    }
  ]
}
Use null quando não tiver certeza do valor. Sem texto fora do JSON."""

resposta = client.chat.completions.create(
    model="gpt-4.1-mini",
    messages=[{"role": "user", "content": prompt}],
    temperature=0.2
)

texto = resposta.choices[0].message.content
texto = texto.strip().removeprefix("```json").removeprefix("```").removesuffix("```").strip()

try:
    dados = json.loads(texto)
    for serie in dados["series"]:
        print(f"Série: {serie['titulo']} ({serie['ano_estreia']})")
        print(f"Gênero: {serie['genero']} | Plataforma: {serie['plataforma']}")
        print(f"Sinopse: {serie['sinopse']}")
        print(f"IMDB: {serie['avaliacao_imdb'] or 'sem avaliação'}")
        print("---")
except json.JSONDecodeError:
    print("JSON inválido. Resposta bruta:")
    print(texto)