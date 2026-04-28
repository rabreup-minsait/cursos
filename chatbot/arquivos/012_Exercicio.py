# Exercício: Criar um chatbot simples que responda a perguntas básicas. 
# O chatbot deve ser capaz de responder a perguntas como "Qual é o seu nome?", 
# "Como você está?" e "Pode me ajudar?". O chatbot deve continuar respondendo 
# até que o usuário digite "sair".   
def responder(user):
    user = user.lower()
    if "oi" in user or "olá" in user:
        return "Olá! Como posso ajudar? 😊"
    if "nome" in user:
        return "Me chamam de Bot. Ainda não tenho um nome oficial!"
    if "tudo bem" in user or "tudo bom" in user:
        return "Estou funcionando perfeitamente, obrigado! 😄"
    if "ajuda" in user or "help" in user:
        return "Posso responder perguntas sobre meu nome e como estou. Tente!"
    return "Hmm, não entendi. Pode reformular?"
def chatbot():
    print("Bot: Olá! Estou aqui. Digite 'sair' para encerrar.\n")
    while True:
        user = input("Você: ")
        if user.lower() == "sair":
            print("Bot: Até logo! 👋")
            break
        resposta = responder(user)
        print(f"Bot: {resposta}")
if __name__ == "__main__":
    chatbot()