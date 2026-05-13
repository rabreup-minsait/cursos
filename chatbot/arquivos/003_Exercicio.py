# def é a palavra-chave usada para definir uma função em Python. 
# A função é um bloco de código reutilizável que realiza uma tarefa específica. 
# No exemplo abaixo, a função chamada "cumprimento" imprime uma mensagem de saudação.
# Cumprimento é o nome da função, e os parênteses indicam que é uma função.
# Dois pontos (:) indicam o início do bloco de código da função.
def cumprimento():
    
# nome é uma variável que armazena o valor retornado pela função input().
# A função input() é usada para obter entrada do usuário. Ela exibe a mensagem fornecida 
# entre parênteses e espera que o usuário digite algo. O valor digitado pelo usuário é 
# então armazenado na variável nome.    
    nome = input("Qual é o seu nome? ")
    
# print() é uma função embutida em Python que exibe a mensagem fornecida entre parênteses
# no console.   
# f"Olá, {nome}! Tudo bem?" é uma string formatada (f-string) que inclui a variável nome
# dentro da string.  
    print(f"Olá, {nome}! Tudo bem?")
    
# If __name__ == "__main__": é uma construção comum em Python que verifica se o script está 
# sendo executado diretamente (como o programa principal) ou importado como um módulo em 
# outro script.
# Se o script estiver sendo executado diretamente, o código dentro do bloco if será executado.
# if é uma função de controle de fluxo que permite executar um bloco de código apenas se 
# uma condição for verdadeira.
# __name__ é uma variável especial em Python que contém o nome do módulo atual. Se o script
# estiver sendo executado diretamente, __name__ será igual a "__main__". 
# Caso contrário, se o script for importado como um módulo, __name__ conterá o nome do módulo.
# == é um operador de comparação que verifica se os valores à esquerda e à direita são iguais.
# "_main__" é uma string que representa o nome do módulo principal, ou seja, o script que 
# está sendo executado diretamente. 
if __name__ == "__main__":
    
# Se a condição if for verdadeira, ou seja, se o script estiver sendo executado diretamente,
# a função cumprimento() será chamada, o que resultará na impressão da mensagem "Olá! Tudo bem?" no console.
    cumprimento()