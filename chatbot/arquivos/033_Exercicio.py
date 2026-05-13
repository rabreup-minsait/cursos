def saudacao(nome):
    mensagem = "Olá, " + nome + "!"
    return mensagem
def chatbot():
    print(saudacao("visitante"))
    while True:
        user = input("Você: ").lower()
        if user == "sair":
            break
        resposta = "Não entendi, pode repetir?"
        print("Bot:", resposta)
chatbot()