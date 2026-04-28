# import serve para importar módulos ou bibliotecas em Python, permitindo que você use suas 
# funcionalidades em seu código.
# os serve para interagir com o sistema operacional, como acessar variáveis de ambiente, manipular arquivos 
# e diretórios, entre outras operações relacionadas ao sistema.
import os
import httpx

#from serve para importar partes específicas de um módulo ou biblioteca, permitindo que você use apenas o que 
# precisa, em vez de importar o módulo inteiro.
# dotenv é uma biblioteca que permite carregar variáveis de ambiente a partir de um arquivo .env, facilitando 
# a configuração de chaves de API e outras informações sensíveis.
from dotenv import load_dotenv

# openai é a biblioteca oficial da OpenAI para interagir com seus modelos de linguagem, como o GPT-4. 
# Ela oferece uma interface para enviar solicitações de completions, chat e outras funcionalidades relacionadas 
# à geração de texto e processamento de linguagem natural.
from openai import OpenAI

# load_dotenv() é uma função da biblioteca dotenv que carrega as variáveis de ambiente definidas em um arquivo 
# .env para o ambiente de execução do Python. Isso permite que você acesse essas variáveis usando os.getenv()
# ou outras funções relacionadas a variáveis de ambiente em seu código. No contexto deste código, ele é usado 
# para carregar a chave de API da OpenAI, que é necessária para autenticar as solicitações feitas à API da OpenAI.
load_dotenv()

# client é usado para criar uma instância da classe OpenAI, que é a interface principal para interagir com 
# os modelos de linguagem da OpenAI. Ele é criado usando a chave de API obtida das variáveis de ambiente, 
# permitindo que você faça solicitações para a API da OpenAI e receba respostas dos modelos de linguagem. 
# No contexto deste código, ele é usado para enviar perguntas do usuário e receber respostas do chatbot.
client = OpenAI(
    
    # api_key é um parâmetro que recebe a chave de API da OpenAI, que é necessária para autenticar as 
    # solicitações feitas à API da OpenAI. Ele é obtido usando os.getenv("OPENAI_API_KEY"), que busca a chave 
    # de API armazenada nas variáveis de ambiente.
    # gentenv("OPENAI_API_KEY") é uma função do módulo os que busca o valor da variável de ambiente 
    # "OPENAI_API_KEY". Essa variável deve conter a chave de API da OpenAI, que é necessária para autenticar 
    # as solicitações feitas à API da OpenAI. Ao usar os.getenv("OPENAI_API_KEY"), você pode acessar a 
    # chave de API de forma segura, sem precisar hardcodá-la diretamente no código, o que é uma prática 
    # recomendada para proteger informações sensíveis.  
    api_key=os.getenv("OPENAI_API_KEY"),
    
    # http_client é um parâmetro que recebe uma instância de httpx.Client, que é usada para fazer as 
    # solicitações HTTP para a API da OpenAI. O parâmetro verify=False é usado para desabilitar a verificação 
    # de certificados SSL, o que pode ser útil em ambientes de desenvolvimento ou teste onde os certificados 
    # SSL podem não ser válidos. No entanto, é importante ter cuidado ao usar verify=False em ambientes de 
    # produção, pois isso pode expor seu aplicativo a riscos de segurança.
    http_client=httpx.Client(verify=False)
)

# print é uma função embutida em Python que exibe uma mensagem ou valor no console. No contexto deste código, 
# ele é usado para informar ao usuário que o chatbot foi iniciado e que ele pode digitar "sair" para encerrar 
# a interação com o chatbot. Para colocar os textos usamos as aspas duplas ("") ou simples ('') para delimitar 
# a string que queremos exibir.
print("Chatbot iniciado. Digite 'sair' para encerrar.")

# While True é uma estrutura de controle de fluxo em Python que cria um loop infinito. O código dentro desse loop
# será executado repetidamente até que uma condição de parada seja atendida, como um comando de saída ou uma 
# interrupção. No contexto deste código, o loop é usado para permitir que o usuário faça perguntas
# ao chatbot continuamente até que ele decida sair digitando "sair".
while True:
    # input é uma função embutida em Python que permite ao usuário inserir dados no console. No contexto deste
    # código, ele é usado para solicitar ao usuário que digite uma pergunta para o chatbot. O texto 
    # "Você: " é exibido como um prompt para indicar que o usuário deve digitar sua pergunta. O método 
    # strip() é usado para remover quaisquer espaços em branco extras no início ou no final da string 
    # digitada pelo usuário, garantindo que a entrada seja processada corretamente.
    pergunta = input("Você: ").strip()
    
    # if é usado para verificar se a pergunta do usuário é igual a "sair" (ignorando maiúsculas e minúsculas). 
    # Se for, o loop é interrompido usando break, encerrando a interação com o chatbot.    
    if pergunta.lower() == "sair":
        break
    
    # not é um operador lógico em Python que inverte o valor de uma expressão. No contexto deste código, 
    # ele é usado para verificar se a pergunta do usuário está vazia (ou seja, se não contém nenhum texto). 
    # Se a pergunta estiver vazia, o código dentro do bloco if será executado, e continue é usado para pular 
    # a iteração atual do loop e passar para a próxima, permitindo que o usuário digite uma nova pergunta sem 
    # processar a entrada vazia.
    if not pergunta:
        continue
    
    # Client.chat.completions.create() é um método da biblioteca OpenAI que é usado para criar uma solicitação de 
    # completions de chat. Ele permite que você envie uma mensagem de usuário para o modelo de linguagem da 
    # OpenAI e receba uma resposta gerada pelo modelo. No contexto deste código, ele é usado para enviar a 
    # pergunta do usuário ao modelo GPT-4o-mini e obter a resposta gerada pelo modelo, que é então impressa 
    # para o usuário. O parâmetro model especifica qual modelo de linguagem da OpenAI deve ser usado para gerar 
    # a resposta, e o parâmetro messages é uma lista de mensagens que compõem a conversa, onde cada mensagem 
    # é um dicionário com um papel (role) e um conteúdo (content). Neste caso, a mensagem enviada ao modelo 
    # tem o papel de "user" e o conteúdo é a pergunta digitada pelo usuário.    
    resposta = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[{"role": "user", "content": pergunta}]
    )
    # f é usado para criar uma string formatada, onde as expressões dentro de chaves {} são avaliadas e inseridas
    # na string resultante. No contexto deste código, ele é usado para formatar a resposta do chatbot de forma 
    # legível para o usuário. A expressão {resposta.choices[0].message.content} é avaliada para obter o conteúdo 
    # da mensagem gerada pelo modelo, que é então inserido na string 
    # "Chatbot: {resposta.choices[0].message.content}" e exibida no console usando print. 
    # Isso permite que o usuário veja a resposta do chatbot de maneira clara e organizada.   
    print(f"Chatbot: {resposta.choices[0].message.content}")