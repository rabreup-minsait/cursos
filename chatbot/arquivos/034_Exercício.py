import unicodedata

def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto

testes = ["Horário", "SAIR", "olá tudo bem?", "ação", "São Paulo"]

for t in testes:
    print(f"'{t}' -> '{normalizar(t)}'")