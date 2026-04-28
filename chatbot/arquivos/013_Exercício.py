# Exercício: Criar um chatbot simples que responda a perguntas sobre o horário, 
# dia da semana e mês atual. O chatbot deve ser capaz de entender perguntas como 
# "Que horas são?", "Que dia é hoje?", "Em que mês estamos?" e responder de forma 
# adequada. O chatbot deve continuar a conversar até que o usuário digite "sair". 
# Use a biblioteca datetime para obter as informações de data e hora. O chatbot 
# deve ser amigável e fácil de usar, incentivando o usuário a fazer perguntas.
from datetime import datetime
def responder(user):
    user = user.lower()
    agora = datetime.now()
    if "oi" in user or "olá" in user:
        return "Olá! Posso te dizer as horas, o dia da semana ou o mês. Pergunte!"
    if "hora" in user:
        return f"Agora são {agora.strftime('%H:%M')}"
    if "semana" in user or "dia" in user:
        dias = {
            "Monday": "segunda-feira", "Tuesday": "terça-feira",
            "Wednesday": "quarta-feira", "Thursday": "quinta-feira",
            "Friday": "sexta-feira", "Saturday": "sábado",
            "Sunday": "domingo"
        }
        return f"Hoje é {dias[agora.strftime('%A')]}"
    if "mês" in user or "mes" in user:
        meses = {
            "January": "janeiro", "February": "fevereiro", "March": "março",
            "April": "abril", "May": "maio", "June": "junho",
            "July": "julho", "August": "agosto", "September": "setembro",
            "October": "outubro", "November": "novembro", "December": "dezembro"
        }
        return f"Estamos em {meses[agora.strftime('%B')]}"
    if "tudo bem" in user:
        return "Estou funcionando perfeitamente 😄"
    return "Não entendi. Tente perguntar sobre horas, dia ou mês!"
def chatbot():
    print("Bot: Olá! Pergunte-me as horas, o dia ou o mês. Digite 'sair' para encerrar.\n")
    while True:
        user = input("Você: ")
        if user.lower() == "sair":
            print("Bot: Até logo! Foi um prazer 👋")
            break
        resposta = responder(user)
        print(f"Bot: {resposta}")
if __name__ == "__main__":
    chatbot()