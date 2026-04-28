import os
import httpx
from dotenv import load_dotenv
from openai import OpenAI
load_dotenv()
client = OpenAI(
    api_key=os.getenv("OPENAI_API_KEY"),
    http_client=httpx.Client(verify=False)
)

# mensagens é uma lista de mensagens que mantém o histórico da conversa entre o usuário e o assistente. 
# Cada mensagem é um dicionário com um papel (role) e um conteúdo (content). O papel pode ser "system" 
# para mensagens de configuração, "user" para mensagens do usuário e "assistant" para mensagens do assistente. 
# O conteúdo é o texto da mensagem. O chatbot inicia com uma mensagem de sistema que define o comportamento 
# do assistente, e depois entra em um loop onde recebe perguntas do usuário, envia essas perguntas para a API 
# do OpenAI, recebe as respostas e as exibe para o usuário. O loop continua até que o usuário digite "sair". 
# role funciona como um indicador de quem está falando, permitindo que o modelo entenda o contexto da 
# conversa e responda de maneira apropriada.    
# content funciona para definir como o chatbot deve se comportar, o que ele deve responder e como ele 
# deve interagir com o usuário. 
mensagens = [
    {
        "role": "system",
        "content": "Você é um assistente claro, direto e didático. Responda sempre em português."
    }
]
print("Chatbot iniciado. Digite 'sair' para encerrar.")
while True:
    pergunta = input("Você: ").strip()
    if pergunta.lower() == "sair":
        print("Bot: Até mais!")
        break
    if not pergunta:
        continue
    mensagens.append({"role": "user", "content": pergunta})
    resposta = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=mensagens
    )
    # choices é uma lista de opções de resposta geradas pelo modelo. Cada opção é um dicionário que contém 
    # uma mensagem (message) com o conteúdo da resposta. A linha 
    # resposta_texto = resposta.choices[0].message.content extrai o texto da primeira opção de resposta 
    # gerada pelo modelo, que é a resposta que será exibida para o usuário. Em seguida, essa resposta é 
    # adicionada ao histórico de mensagens como uma mensagem do assistente e exibida no console.    
    resposta_texto = resposta.choices[0].message.content
    mensagens.append({"role": "assistant", "content": resposta_texto})
    print("Bot:", resposta_texto)