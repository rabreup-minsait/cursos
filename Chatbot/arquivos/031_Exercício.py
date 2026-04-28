def apresentar(nome, funcao):
    texto = "Olá! Sou " + nome + ", seu assistente de " + funcao + "."
    return texto

modelo = "gpt-4o-mini"
resultado = apresentar("Max", "suporte")
print(resultado)
print("Modelo:", modelo)