# def é uma palavra reservada em Python usada para definir uma função. 
# Uma função é um bloco de código reutilizável que realiza uma tarefa específica. 
# No exemplo abaixo, a função chatbot() é definida para criar um chatbot simples 
# que repete o que o usuário digita. 
# chatbot é o nome da função, e o código dentro dela é o que será executado 
# quando a função for chamada.      
def chatbot():
# while True: é um loop infinito que permite que o chatbot continue funcionando 
# até que seja interrompido manualmente.       
    while True:
# user é uma variável que armazena a entrada do usuário. 
# input() é uma função usada para solicitar que o usuário digite algo
# "Você: " é exibido como um prompt para o usuário. 
# O que o usuário digitar será armazenado na variável user.   
        user = input("Você: ")
# if é uma estrutura de controle de fluxo que permite executar um bloco de código 
# somente se uma condição for verdadeira. Neste caso, a condição é se 
# o usuário digitou "sair". 
        if user == "sair":
# break é uma palavra reservada em Python usada para sair de um loop. 
# Se o usuário digitar "sair", o loop while será interrompido 
# e o chatbot será encerrado.            
            break
# print() é uma função usada para exibir informações na tela. 
# "Bot: " é exibido antes da resposta do chatbot, e user é a resposta do chatbot, 
# que é simplesmente o que o usuário digitou.           
        print("Bot:", user)
# A função chatbot() é chamada para iniciar o chatbot.
chatbot()