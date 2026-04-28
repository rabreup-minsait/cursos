def responder(user):
    user = user.lower()
    if user == "oi":
# retorna uma resposta para o usuário
# O chatbot responde de acordo com a entrada do usuário 
# se o usuário digitar "oi", o chatbot responde com uma saudação       
        return "Olá! Tudo bem?"
#se o usuário digitar "tudo bem", o chatbot responde que está funcionando perfeitamente
    if user == "tudo bem":
        return "Estou funcionando perfeitamente 😄"
# se disser algo diferente de oi ou tudo bem, o chatbot responde que não entendeu 
# e pede para reformular a pergunta 
    return "Não entendi. Pode reformular?"
# foi criada duas funções, uma para responder as perguntas do usuário e outra para o 
# chatbot interagir com o usuário, onde o chatbot fica em um loop até que o 
# usuário digite "sair" para encerrar a conversa. 
# Fazer as funções separadas é uma boa prática de programação, pois torna o 
# código mais organizado e fácil de entender.  
def chatbot():
    print("Bot: Olá! Digite 'sair' para encerrar.\n")
    while True:
        user = input("Você: ")
        if user.lower() == "sair":
            print("Bot: Encerrando... até logo!")
            break
        resposta = responder(user)
        print(f"Bot: {resposta}")
if __name__ == "__main__":
    chatbot()