FAQ = [
    {
        "palavras": ["horario", "funcionamento", "abre", "fecha"],
        "resposta": "A TechShop atende de segunda a sexta, das 9h às 18h, e aos sábados, das 9h às 13h."
    },
    {
        "palavras": ["endereco", "loja", "localizacao", "onde fica"],
        "resposta": "A loja fica na Avenida Central, 1000, perto da estação principal."
    },
    {
        "palavras": ["troca", "devolucao", "garantia"],
        "resposta": "A troca pode ser solicitada em até 7 dias, com nota fiscal e produto sem sinais de uso."
    },
    {
        "palavras": ["pagamento", "cartao", "pix", "boleto"],
        "resposta": "Aceitamos Pix, cartão de crédito, cartão de débito e boleto para compras pelo site."
    }
]
def buscar_faq(texto_normalizado):
    for item in FAQ:
        for palavra in item["palavras"]:
            if palavra in texto_normalizado:
                return item["resposta"]
    return None