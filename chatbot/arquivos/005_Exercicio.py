def boas_vindas():
    nome  = input("Qual é o seu nome? ")
    idade = int(input("Qual é a sua idade? "))  # int() converte texto em número

    print(f"Olá, {nome}! Seja bem-vindo(a)!")

    if idade < 18:
        print("Você é jovem!")
    else:
        print("Bem-vindo, adulto!")

if __name__ == "__main__":
    boas_vindas()