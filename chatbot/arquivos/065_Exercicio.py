import unicodedata
def normalizar(t: str) -> str:
    t = t.lower()
    t = unicodedata.normalize("NFD", t)
    return "".join(c for c in t if unicodedata.category(c) != "Mn")
# dominio: restaurante
CARDAPIO = {
    "frango grelhado": {"preco": "R$ 38", "desc": "Com arroz, feijao e salada", "ok": True},
    "file mignon":    {"preco": "R$ 65", "desc": "Ao molho com batatas",        "ok": True},
    "risoto camarao": {"preco": "R$ 55", "desc": "Risoto cremoso",               "ok": False},
    "lasanha bolonhesa": {"preco": "R$ 42", "desc": "Bolonhesa tradicional",       "ok": True},
}
HORARIOS = {"seg-sex": "12h-15h e 19h-23h", "sabado": "12h-23h", "domingo": "12h-16h"}
def classificar(texto: str) -> str:
    t = normalizar(texto)
    if any(g in t for g in ["reserva", "mesa", "lugar"]):   return "reserva"
    if any(g in t for g in ["horario", "abre", "fecha"]): return "horario"
    if any(g in t for g in ["cardapio", "preco", "prato",
                                        "frango", "file", "risoto", "lasanha"]): return "cardapio"
    return "conversa"
def buscar_prato(texto: str) -> str:
    t = normalizar(texto)
    r = [f"{n.title()}: {d['preco']} | {d['desc']} | {'disponivel' if d['ok'] else 'indisponivel'}"
         for n, d in CARDAPIO.items() if any(p in t for p in normalizar(n).split())]
    if not r: r = [f"{n.title()}: {d['preco']}" for n, d in CARDAPIO.items()]
    return "\n".join(r)
def buscar_horario(texto: str) -> str:
    t = normalizar(texto)
    if "sabado" in t: return f"Sabado: {HORARIOS['sabado']}"
    if "domingo" in t: return f"Domingo: {HORARIOS['domingo']}"
    return f"Seg-sex: {HORARIOS['seg-sex']} | Sab: {HORARIOS['sabado']} | Dom: {HORARIOS['domingo']}"
if __name__ == "__main__":
    testes = ["Qual o preco do frango?", "Que horas abre?", "Quero reservar mesa",
              "Tem lasanha hoje?", "O que voces servem?", "Aceitam cartao?",
              "Funciona domingo?", "Tem risoto?", "Horario de sabado?", "Boa tarde!"]
    for m in testes:
        c = classificar(m)
        print(f"[{c}] {m}")
        if c == "cardapio": print("  ->", buscar_prato(m))
        elif c == "horario": print("  ->", buscar_horario(m))
        print()