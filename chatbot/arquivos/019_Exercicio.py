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
        if any(kw in user for kw in intent["keywords"]):
            resposta = intent["action"]()
            respostas.append(resposta)
            if intent["action"] == sair:
                encerrar = True
    return respostas, encerrar
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