import unicodedata
def normalizar(texto: str) -> str:
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    return "".join(c for c in texto if unicodedata.category(c) != "Mn")
# base de dados local - em producao viria de planilha ou banco
PRODUTOS = {
    "notebook pro":    {"preco": "R$ 4.500", "estoque": "disponivel", "descricao": "16GB RAM, SSD 512GB"},
    "mouse sem fio":   {"preco": "R$ 120",   "estoque": "disponivel", "descricao": "Ergonomico 2.4GHz"},
    "teclado mecanico":{"preco": "R$ 350",   "estoque": "esgotado",   "descricao": "Switch azul"},
    "monitor 24":      {"preco": "R$ 1.200",  "estoque": "disponivel", "descricao": "Full HD 24 pol"},
}
def classificar(texto: str) -> str:
    t = normalizar(texto)
    if any(g in t for g in ["meu nome", "eu me chamo", "quem eu sou"]):
        return "dados_usuario"
    if any(g in t for g in ["preco", "valor", "custa", "estoque", "disponivel",
                                        "notebook", "mouse", "teclado", "monitor"]):
        return "busca_produto"
    return "conversa"
def buscar_produto(texto: str) -> str:
    t = normalizar(texto)
    encontrados = [
        f"{nome.title()}: {d['preco']}, {d['estoque']}, {d['descricao']}"
        for nome, d in PRODUTOS.items()
        if any(p in t for p in normalizar(nome).split())
    ]
    return "\n".join(encontrados) if encontrados else "Nenhum produto encontrado."
if __name__ == "__main__":
    testes = [
        "Qual o preco do notebook?",
        "Meu nome e Ana",
        "Tem teclado disponivel?",
        "Boa tarde, pode me ajudar?",
        "Quanto custa o monitor?",
    ]
    for msg in testes:
        cat = classificar(msg)
        print(f"[{cat}] {msg}")
        if cat == "busca_produto":
            print("  Dados:", buscar_produto(msg))
        print()