import unicodedata
def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto
entrada = input("Digite uma palavra ou frase: ")
resultado = normalizar(entrada)
print(resultado)