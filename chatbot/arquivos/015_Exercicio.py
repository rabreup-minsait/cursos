# Exercício: Criar um chatbot simples que responda a perguntas sobre a hora, 
# data e dia da semana.          
from datetime import datetime
# unicodedata é usado para remover acentos e normalizar o texto para facilitar 
# a comparação.   
import unicodedata
def normalizar(texto):
    texto = texto.lower()
# .join é usado para reconstruir o texto sem os caracteres acentuados. A função 
# unicodedata.category(c) retorna a categoria do caractere, e "Mn" indica que é 
# um caractere de marcação (como acentos). Assim, estamos removendo todos os 
# caracteres acentuados do texto.
# for é usado para iterar sobre cada caractere do texto e construir uma nova string 
# sem os acentos. O resultado é um texto normalizado, facilitando a comparação com as 
# palavras-chave do chatbot.
# category(c) é uma função da biblioteca unicodedata que retorna a categoria de um 
# caractere. 
# Um exemplo de alteração que o MN pode causar é transformar "Olá" em "Ola", 
# removendo o acento agudo. Isso facilita a comparação com palavras-chave como "oi" 
# ou "ola", independentemente de acentos.  
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
# weekday() retorna o dia da semana como um número inteiro, onde segunda-feira é 0 e 
# domingo é 6.       
    return f"Hoje é {dias[datetime.now().weekday()]}"
def chatbot():
    print("Chat iniciado...")
    while True:
        user = normalizar(input("Você: "))
        respostas = []
        if "oi" in user:
            respostas.append("Olá!")
        if "hora" in user:
            respostas.append(get_hora())
        if "data" in user:
            respostas.append(get_data())
        if "dia" in user:
            respostas.append(get_dia_semana())
        if "sair" in user:
            print("Encerrando...")
            break
        if not respostas:
            print("Bot: Não entendi...")
        else:
            for r in respostas:
                print("Bot:", r)
chatbot()