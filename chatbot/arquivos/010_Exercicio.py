# from é uma palavra-chave em Python usada para importar funções, classes ou variáveis 
# específicas de um módulo. Neste código, estamos  importando a classe 
# datetime do módulo datetime para obter a data e hora atuais. 
# import é usado para importar um módulo inteiro, enquanto from é usado para 
# importar partes específicas de um módulo.
from datetime import datetime
# datetime.now() é um método da classe datetime que retorna a data e hora atuais 
# como um objeto datetime. Ele é usado para obter a data e hora atuais do sistema, 
# permitindo que o chatbot responda com informações atualizadas sobre o tempo e 
# o dia da semana.
def responder(user):
    user = user.lower()
    agora = datetime.now()
# in é um operador de associação em Python que verifica se um valor está presente
# em uma sequência (como uma string, lista ou tupla). Neste código, estamos usando 
# o operador in para verificar se certas palavras ou frases estão presentes na 
#  entrada do usuário (user). Por exemplo, if "oi" in user verifica se a palavra "oi" está presente na string user. Se estiver, o chatbot responde com uma saudação. O operador in é útil para criar respostas baseadas em palavras-chave, permitindo que o chatbot entenda e responda a
    if "oi" in user or "olá" in user:
        return "Olá! Tudo bem? Como posso ajudar?"
# strftime é um método de formatação de data e hora em Python que permite formatar um 
# objeto datetime em uma string de acordo com um formato especificado. No código, 
# estamos usando strftime para formatar a data e hora atuais (agora) em diferentes 
# formatos, dependendo da pergunta do usuário. Por exemplo, agora.strftime('%H:%M') 
# retorna a hora e os minutos no formato de 24 horas, enquanto agora.strftime('%A')
# retorna o nome completo do dia da semana. Isso permite que o chatbot responda com 
# informações específicas sobre a hora ou o dia da semana.   
    if "hora" in user:
        return f"Agora são {agora.strftime('%H:%M')}"
    if "dia" in user or "semana" in user:
        dias = {
            "Monday": "segunda-feira", "Tuesday": "terça-feira",
            "Wednesday": "quarta-feira", "Thursday": "quinta-feira",
            "Friday": "sexta-feira", "Saturday": "sábado",
            "Sunday": "domingo"
        }
        return f"Hoje é {dias[agora.strftime('%A')]}"
    if "tudo bem" in user:
        return "Estou funcionando perfeitamente 😄"
    return "Não entendi. Pode reformular?"
def chatbot():
    print("Bot: Olá! Pergunte-me as horas, o dia da semana, ou diga 'sair'.\n")
    while True:
        user = input("Você: ")
        if user.lower() == "sair":
            print("Bot: Encerrando... até logo!")
            break
        resposta = responder(user)
        print(f"Bot: {resposta}")
if __name__ == "__main__":
    chatbot()
