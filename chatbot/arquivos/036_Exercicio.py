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

prompt = """Me dê 3 filmes de comédia brasileiros premiados.
Responda APENAS em JSON válido, sem nenhum texto fora do JSON.
Use exatamente esta estrutura para cada filme:
{
  "filmes": [
    {
      "titulo": "string",
      "diretor": "string",
      "ano": número,
      "sinopse": "string com 1 frase",
      "premio": "string descrevendo o prêmio principal",
      "plataforma": "string ou null se não souber"
    }
  ]
}
Regras: retorne apenas JSON válido. Se não tiver certeza de algum campo, use null."""

resposta = client.chat.completions.create(
    model="gpt-4.1-mini",
    messages=[{"role": "user", "content": prompt}],
    temperature=0.2
)

texto = resposta.choices[0].message.content
texto = texto.strip().removeprefix("```json").removeprefix("```").removesuffix("```").strip()

print("Resposta da IA:")
print(texto)
print("---")

try:
    dados = json.loads(texto)
    print("\nPrimeiro filme:", dados["filmes"][0]["titulo"])
except json.JSONDecodeError:
    print("A IA não retornou JSON válido.")