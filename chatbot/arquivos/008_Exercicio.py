def chatbot():
# \n é usado para criar uma nova linha, melhorando a formatação da saída.
    print("Bot: Olá! Digite 'sair' para encerrar.\n")

    while True:
        user = input("Você: ")

# O método lower() é usado para converter a entrada do usuário para minúsculas, 
# garantindo que a comparação seja case-insensitive.  
        if user.lower() == "sair":
            print("Bot: Encerrando... até logo!")
            break

        print(f"Bot: Você disse: {user}")

if __name__ == "__main__":
    chatbot()