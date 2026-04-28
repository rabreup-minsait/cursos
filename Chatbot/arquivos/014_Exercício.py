from datetime import datetime
def get_hora():
    agora = datetime.now()
    return f"Agora são {agora.hour}:{agora.minute:02d}"
def get_data():
    agora = datetime.now()
    return f"Hoje é {agora.day}/{agora.month}/{agora.year}"
def get_dia_semana():
    dias = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"]
    hoje = datetime.now()
    return f"Hoje é {dias[hoje.weekday()]}"
#append() para adicionar respostas, break para encerrar o loop, e verificação correta 
# de lista vazia para evitar mensagens de erro. O chatbot agora responde a "oi", 
# "hora", "data", "dia" e "sair". Se o usuário digitar algo que não seja reconhecido, 
# o bot responderá "Não entendi...".
def chatbot():
    print("Chat iniciado...")
    while True:
        user = input("Você: ").lower()
        respostas = []
        if "oi" in user:
            respostas.append("Olá!")
        if "hora" in user:
            respostas.append(get_hora())   # ✓ com parênteses
        if "data" in user:
            respostas.append(get_data())
        if "dia" in user:
            respostas.append(get_dia_semana())
        if "sair" in user:
            print("Encerrando...")
            break                          # ✓ break adicionado
        if not respostas:                 # ✓ verificação correta de lista vazia
            print("Bot: Não entendi...")
        else:
            for r in respostas:
                print("Bot:", r)
chatbot()