# import é o comando usado para importar bibliotecas ou módulos em Python. 
# Neste caso, estamos importando a biblioteca 
# Tiktoken, que é usada para contar tokens em um texto.   
import tiktoken

# texto é uma variável que armazena o texto digitado pelo usuário.
# input é uma função que permite ao usuário inserir dados.
# A mensagem "Digite o texto para contar tokens: " é exibida para o usuário,
# solicitando que ele insira o texto que deseja contar os tokens. Esse texto deve ser escrito entre aspas.
texto = input("Digite o texto para contar tokens: ")

# enc é uma variável que armazena o codificador de tokens para o modelo "gpt-4o-mini".
# tiktoken.encoding_for_model é uma função que retorna o codificador de tokens específico para o modelo 
# fornecido como argumento.   
# "gpt-4o-mini" é o nome do modelo para o qual queremos obter o codificador de tokens.
enc = tiktoken.encoding_for_model("gpt-4o-mini")

# tokens é uma variável que armazena a lista de tokens gerada a partir do texto.
# enc.encode é uma função que codifica o texto em uma lista de tokens usando o codificador de tokens 
# armazenado em enc.     
tokens = enc.encode(texto)

# print é uma função que exibe informações na tela.
# len é uma função que retorna o número de itens em um objeto, como uma lista ou uma string.
# char/tokens é a razão entre o número de caracteres e o número de tokens, que é calculada dividindo o 
# comprimento do texto pelo número de tokens.  
# 1f é uma formatação de string que exibe o número com uma casa decimal.
print(f"Tokens: {len(tokens)}")
print(f"Caracteres: {len(texto)}")
print(f"Razão (chars/token): {len(texto)/len(tokens):.1f}")