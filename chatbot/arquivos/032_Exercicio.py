versao_bot = "v1.0"

def chatbot():
    print("Chat iniciado. Digite 'sair' para encerrar.")
    while True:
        user = input("Você: ").lower()
        if user == "sair":
            break
        if "oi" in user:
            print("Bot: Olá!", versao_bot)
        else:
            print("Bot: Não entendi.")

chatbot()