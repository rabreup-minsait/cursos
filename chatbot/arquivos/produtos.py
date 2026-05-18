PRODUTOS = {
    "iphone 14": {
        "nome": "iPhone 14",
        "preco": "R$ 4.299,00",
        "estoque": 8,
        "descricao": "Smartphone Apple com 128 GB, câmera dupla e tela de 6,1 polegadas."
    },
    "notebook pro 14": {
        "nome": "Notebook Pro 14",
        "preco": "R$ 5.899,00",
        "estoque": 5,
        "descricao": "Notebook com 16 GB de memória, SSD de 512 GB e tela de 14 polegadas."
    },
    "fone bluetooth x": {
        "nome": "Fone Bluetooth X",
        "preco": "R$ 249,90",
        "estoque": 20,
        "descricao": "Fone sem fio com cancelamento de ruído e bateria de até 30 horas."
    }
}
GATILHOS_PRODUTO = [
    "produto",
    "preco",
    "valor",
    "estoque",
    "disponivel",
    "comprar",
    "iphone",
    "notebook",
    "fone"
]
def parece_pergunta_de_produto(texto_normalizado):
    return any(gatilho in texto_normalizado for gatilho in GATILHOS_PRODUTO)
def buscar_produto(texto_normalizado):
    for nome_normalizado, dados in PRODUTOS.items():
        if nome_normalizado in texto_normalizado:
            return dados
    return None
def nomes_cadastrados():
    return [dados["nome"] for dados in PRODUTOS.values()]