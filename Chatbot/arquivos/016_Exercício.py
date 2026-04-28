from datetime import datetime
import unicodedata
def normalizar(texto):
    texto = texto.lower()
    texto = "".join(c for c in texto if unicodedata.category(c) != "Mn")
    return texto
def get_hora():
    agora = datetime.now()
    return f"Agora são {agora.hour}:{agora.minute:02d}"
def get_data():
    agora = datetime.now()
    return f"Hoje é {agora.day}/{agora.month}/{agora.year}"
def get_dia_semana():
    dias = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"]
    return f"Hoje é {dias[datetime.now().weekday()]}"
def sair():
    return "Encerrando..."
# Intents é um dicionário que mapeia intenções a palavras-chave e ações correspondentes.
# O chatbot verifica as intenções com base nas palavras-chave presentes na entrada 
# do usuário e executa a ação associada.
# lambda é usada para criar funções anônimas, como a resposta de saudação, sem a 
# necessidade de definir uma função separada.    
INTENTS = {
    "saudacao": {
        "keywords": ["oi", "ola", "eae"],
        "action": lambda: "Olá! Como posso ajudar?"
    },
    "hora": {
        "keywords": ["hora", "horas"],
        "action": get_hora
    },
    "data": {
        "keywords": ["data", "hoje"],
        "action": get_data
    },
    "dia_semana": {
        "keywords": ["dia", "semana"],
        "action": get_dia_semana
    },
    "sair": {
        "keywords": ["sair", "tchau", "ate mais"],
        "action": sair
    }
}
def detectar_intencoes(user):
    respostas = []
    encerrar = False
    for intent in INTENTS.values():
# any é uma função embutida do Python que retorna True se pelo menos um dos elementos 
# de um iterável for verdadeiro. No caso do chatbot, ele é usado para verificar se 
# alguma das palavras-chave associadas a uma intenção está presente na entrada do 
# usuário. Se alguma palavra-chave for encontrada, a ação correspondente à intenção 
# é executada e a resposta é adicionada à lista de respostas. Se a ação for a função 
# de sair, a variável encerrar é definida como True para indicar que o chatbot deve 
# encerrar a conversa.              
        if any(kw in user for kw in intent["keywords"]):
            resposta = intent["action"]()
            respostas.append(resposta)
            if intent["action"] == sair:
                encerrar = True
    return respostas, encerrar
# not é usado para inverter o valor de uma expressão booleana. No caso do chatbot, ele 
# é utilizado para verificar se a lista de respostas está vazia. Se a lista estiver 
# vazia, significa que nenhuma intenção foi detectada, e o chatbot responde com 
# "Não entendi...". Caso contrário, ele imprime as respostas correspondentes às 
# intenções detectadas.   
def chatbot():
    print("Chat iniciado...")
    while True:
        user = normalizar(input("Você: "))
        respostas, encerrar = detectar_intencoes(user)
        if not respostas:
            print("Bot: Não entendi...")
        else:
            for r in respostas:
                print("Bot:", r)
        if encerrar:
            break
chatbot()