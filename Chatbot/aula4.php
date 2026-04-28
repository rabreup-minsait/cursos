<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aula 4 - Chatbots com Python</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Nunito:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --bg:        #f8f7f5;
  --surface:   #ffffff;
  --border:    #e2ddd8;
  --text:      #1e1916;
  --text2:     #3d3630;
  --text3:     #7a726a;
  --accent:    #1f5fa6;
  --accent-lt: #e8f0fb;
  --green:     #0d6e50;
  --green-lt:  #e4f3ed;
  --gold:      #a06820;
  --gold-lt:   #fdf2e0;
  --red:       #a83030;
  --red-lt:    #fceeed;
  --board:     #182e1e;
  --shadow-sm: 0 1px 4px rgba(30,25,22,.09);
  --shadow:    0 2px 4px rgba(30,25,22,.07), 0 6px 18px rgba(30,25,22,.08);
}
* { margin:0; padding:0; box-sizing:border-box; }
html { font-size:16px; scroll-behavior:smooth; }
body { background:var(--bg); color:var(--text2); font-family:'Nunito',system-ui,sans-serif; line-height:1.85; }

/* ── SCREENSHOT DE INSTALAÇÃO ── */
.install-step {
  margin: 24px 0;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}
.install-step-head {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 16px;
  background: var(--bg);
  border-bottom: 1px solid var(--border);
  font-size: .82rem; font-weight: 800; color: var(--text2);
}
.install-num {
  width: 22px; height: 22px; border-radius: 50%;
  background: var(--accent); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Fira Code', monospace; font-size: 11px;
  flex-shrink: 0;
}
.install-step img { width: 100%; display: block; }
.install-step-desc {
  padding: 10px 16px;
  font-size: .85rem; color: var(--text2); line-height: 1.7;
  border-top: 1px solid var(--border);
}

/* ── LOUSA - compacta, como uma anotação no quadro ── */
.lousa {
  background: var(--board);
  border-radius: 6px;
  padding: 14px 18px;
  margin: 22px auto;
  max-width: 480px;
  box-shadow: var(--shadow-sm);
}
.lousa-title {
  font-family: 'Nunito', sans-serif; font-weight: 800;
  font-size: .7rem; text-transform: uppercase; letter-spacing: .1em;
  color: #6aaa78; margin-bottom: 10px;
}
.lousa-row {
  display: flex; gap: 9px; align-items: flex-start;
  margin-bottom: 7px; font-size: .86rem;
  color: #c8e4cc; line-height: 1.6;
  font-family: 'Nunito', sans-serif;
}
.lousa-row:last-child { margin-bottom: 0; }
.lousa-row .bul { color: #5ad68a; flex-shrink: 0; margin-top: 2px; }
.lousa strong { color: #e8f5e8; font-weight: 700; }
.lousa code { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.18); color: #a8e8c0; font-size: .8em; }

.topbar { background:var(--surface); border-bottom:1px solid var(--border); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:48px; position:sticky; top:0; z-index:50; }
.tb-logo { display:flex; align-items:center; gap:8px; text-decoration:none; font-weight:800; font-size:.85rem; color:var(--text); }
.tb-logo-icon { width:24px; height:24px; background:var(--accent); border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:12px; }
.tb-nav { display:flex; align-items:center; gap:4px; }
.tb-btn { display:inline-flex; align-items:center; gap:5px; font-size:.78rem; font-weight:700; color:var(--text3); text-decoration:none; padding:5px 10px; border:1px solid var(--border); border-radius:5px; background:var(--bg); transition:all .15s; }
.tb-btn:hover { border-color:var(--accent); color:var(--accent); }
.tb-btn.next { background:var(--accent); color:#fff; border-color:var(--accent); }
.tb-btn.next:hover { background:#1a4f8a; }
.tb-lesson { font-family:'Fira Code',monospace; font-size:10.5px; color:var(--text3); letter-spacing:.06em; padding:0 12px; }

.prog { position:fixed; top:0; left:0; height:2px; background:var(--accent); z-index:100; width:0; transition:width .1s; }
.wrap { max-width:680px; margin:0 auto; padding:44px 28px 90px; }

.cover { margin-bottom:52px; }
.cover-tag { font-family:'Fira Code',monospace; font-size:10px; letter-spacing:.2em; text-transform:uppercase; color:var(--text3); margin-bottom:12px; display:block; }
.cover h1 { font-family:'Playfair Display',serif; font-size:clamp(1.7rem,3.5vw,2.3rem); font-weight:700; line-height:1.2; color:var(--text); margin-bottom:16px; }
.cover h1 em { color:var(--accent); font-style:italic; }
.cover p { font-size:1rem; color:var(--text2); line-height:1.85; }

p { font-size:.97rem; color:var(--text2); margin-bottom:20px; line-height:1.85; }
p:last-child { margin-bottom:0; }
strong { color:var(--text); font-weight:700; }
code { font-family:'Fira Code',monospace; font-size:.82em; background:var(--accent-lt); border:1px solid rgba(31,95,166,.16); border-radius:4px; padding:1px 6px; color:var(--accent); }

.bubble { display:flex; gap:10px; align-items:flex-start; margin:28px 0 8px; }
.bubble-avatar { flex-shrink:0; width:32px; height:32px; background:#f0a500; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; margin-top:2px; box-shadow:0 2px 6px rgba(240,165,0,.3); }
.bubble-body { background:#fffbf0; border:1.5px solid #f0c040; border-radius:4px 14px 14px 14px; padding:11px 15px; font-size:.9rem; color:#4a3800; font-weight:600; box-shadow:0 2px 8px rgba(240,165,0,.15); line-height:1.65; max-width:500px; }

.dica { border-left:3px solid var(--accent); background:var(--accent-lt); border-radius:0 7px 7px 0; padding:12px 16px; margin:20px 0; font-size:.9rem; color:#1a3a6a; line-height:1.75; }
.dica strong { color:#1a3a6a; font-weight:800; }
.atencao { border-left:3px solid var(--gold); background:var(--gold-lt); border-radius:0 7px 7px 0; padding:12px 16px; margin:20px 0; font-size:.9rem; color:#5a3808; line-height:1.75; }
.atencao strong { color:#5a3808; font-weight:800; }
.aviso { border-left:3px solid var(--red); background:var(--red-lt); border-radius:0 7px 7px 0; padding:12px 16px; margin:20px 0; font-size:.9rem; color:#6a1515; line-height:1.75; }
.aviso strong { color:#6a1515; font-weight:800; }

.cblock { background:#f5f3f0; border:1px solid #ddd8d0; border-radius:8px; margin:20px 0; overflow:hidden; box-shadow:var(--shadow-sm); }
.cblock-head { display:flex; align-items:center; justify-content:space-between; padding:7px 14px; background:var(--surface); border-bottom:1px solid #ddd8d0; }
.cdots { display:flex; gap:5px; }
.cdots span { width:9px; height:9px; border-radius:50%; }
.c1{background:#ff6058;} .c2{background:#ffbd2e;} .c3{background:#28ca42;}
.cfname { font-family:'Fira Code',monospace; font-size:10.5px; color:var(--text3); }
.cblock pre { padding:16px 18px; font-family:'Fira Code',monospace; font-size:13px; line-height:1.8; overflow-x:auto; color:#2a2420; white-space:pre; }
.kw{color:#6d28d9;} .fn{color:#1d4ed8;} .st{color:#166534;}
.nm{color:#b45309;} .cm{color:#888078;font-style:italic;}
.vr{color:#b91c1c;} .op{color:#0d6e50;} .bi{color:#a06820;}

.code-ann { margin:16px 0 24px; border-collapse:collapse; width:100%; }
.code-ann tr { border-bottom:1px solid var(--border); }
.code-ann tr:last-child { border-bottom:none; }
.code-ann td { padding:8px 10px; font-size:.85rem; vertical-align:top; line-height:1.65; }
.code-ann td:first-child { font-family:'Fira Code',monospace; font-size:.78rem; white-space:nowrap; color:var(--accent); background:var(--accent-lt); border-radius:4px; width:1%; padding:8px 12px; }
.code-ann td:last-child { color:var(--text2); }
.code-ann td strong { color:var(--text); }

.param-table { width:100%; border-collapse:collapse; margin:20px 0 28px; font-size:.87rem; }
.param-table thead th { background:var(--accent); color:#fff; padding:9px 13px; text-align:left; font-size:.78rem; font-family:'Fira Code',monospace; letter-spacing:.05em; }
.param-table thead th:first-child { border-radius:6px 0 0 0; }
.param-table thead th:last-child  { border-radius:0 6px 0 0; }
.param-table tbody tr { border-bottom:1px solid var(--border); }
.param-table tbody tr:last-child { border-bottom:none; }
.param-table tbody td { padding:9px 13px; vertical-align:top; line-height:1.65; color:var(--text2); }
.param-table tbody td:first-child { font-family:'Fira Code',monospace; font-size:.8rem; color:var(--accent); white-space:nowrap; background:var(--accent-lt); }
.param-table tbody td:nth-child(2) { font-size:.82rem; color:var(--text3); white-space:nowrap; }
.param-table tbody td strong { color:var(--text); font-weight:700; }

.modo-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin:22px 0; }
.modo-card { border-radius:8px; padding:14px 16px; border:1.5px solid; }
.modo-criativo  { background:#fdf3ff; border-color:#9333ea; }
.modo-tecnico   { background:#eff6ff; border-color:#1d4ed8; }
.modo-economico { background:#f0fdf4; border-color:#15803d; }
.modo-label { font-family:'Fira Code',monospace; font-size:9.5px; letter-spacing:.15em; text-transform:uppercase; margin-bottom:7px; display:block; font-weight:700; }
.modo-criativo  .modo-label { color:#9333ea; }
.modo-tecnico   .modo-label { color:#1d4ed8; }
.modo-economico .modo-label { color:#15803d; }
.modo-card p { font-size:.81rem; line-height:1.6; margin:0; color:var(--text2); }
.modo-card code { font-size:.75em; }

.break { background:var(--gold-lt); border:1px solid rgba(160,104,32,.2); border-radius:8px; padding:18px 22px; text-align:center; margin:44px 0; }
.break .be { font-size:1.8rem; display:block; margin-bottom:6px; }
.break h3 { font-family:'Playfair Display',serif; color:var(--gold); font-size:1rem; font-style:normal; margin-bottom:4px; }
.break p { font-size:.83rem; color:#7a5010; margin:0; }

.exercise { background:var(--surface); border:1.5px solid var(--accent); border-radius:8px; padding:20px 22px; margin:32px 0; box-shadow:var(--shadow-sm); }
.ex-tag { font-family:'Fira Code',monospace; font-size:9.5px; letter-spacing:.18em; color:var(--accent); text-transform:uppercase; margin-bottom:8px; display:block; }
.exercise h3 { font-family:'Playfair Display',serif; color:var(--text); font-size:1.05rem; margin-bottom:12px; }
.exercise ol { padding-left:18px; font-size:.88rem; line-height:2.1; color:var(--text2); }
.ex-diff { font-family:'Fira Code',monospace; font-size:9px; letter-spacing:.12em; text-transform:uppercase; padding:2px 8px; border-radius:3px; margin-left:8px; }
.diff-1 { background:var(--green-lt); color:var(--green); }
.diff-2 { background:var(--gold-lt);  color:var(--gold); }
.diff-3 { background:var(--red-lt);   color:var(--red); }
.ex-ans { margin-top:14px; padding-top:14px; border-top:1px solid var(--border); }
.ex-ans-body { display:none; }
.ex-ans-body.visible { display:block; }
.btn-ans { display:inline-flex; align-items:center; gap:6px; font-family:'Fira Code',monospace; font-size:.75rem; font-weight:600; color:var(--green); background:var(--green-lt); border:1.5px solid rgba(13,110,80,.25); border-radius:5px; padding:6px 14px; cursor:pointer; transition:all .15s; margin-top:4px; letter-spacing:.03em; }
.btn-ans:hover { background:#d0ece3; border-color:rgba(13,110,80,.5); }

.downloads { margin:48px 0 32px; }
.downloads-title { font-family:'Fira Code',monospace; font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:var(--text3); margin-bottom:12px; display:block; }
.dl-grid { display:flex; flex-direction:column; gap:7px; }
.dl-item { display:flex; align-items:center; gap:12px; background:var(--surface); border:1px solid var(--border); border-radius:7px; padding:10px 14px; text-decoration:none; color:inherit; box-shadow:var(--shadow-sm); transition:border-color .15s,box-shadow .15s; }
.dl-item:hover { border-color:var(--accent); box-shadow:var(--shadow); }
.dl-icon { font-size:1.1rem; flex-shrink:0; }
.dl-info { flex:1; }
.dl-name { font-family:'Fira Code',monospace; font-size:.78rem; color:var(--accent); font-weight:500; }
.dl-desc { font-size:.75rem; color:var(--text3); margin-top:1px; }
.dl-badge { font-family:'Fira Code',monospace; font-size:9px; background:var(--accent-lt); color:var(--accent); border-radius:4px; padding:2px 8px; flex-shrink:0; }

.ready { background:var(--green-lt); border:1.5px solid rgba(13,110,80,.3); border-radius:8px; padding:26px; text-align:center; margin:48px 0; }
.ready .re { font-size:2rem; display:block; margin-bottom:10px; }
.ready h2 { font-family:'Playfair Display',serif; color:var(--green); font-size:1.25rem; margin:0 0 8px; }
.ready p { font-size:.88rem; color:#0a4535; margin:0; }

.nav-bottom { display:flex; justify-content:space-between; margin-top:52px; padding-top:20px; border-top:1px solid var(--border); }
.nav-link { display:inline-flex; align-items:center; gap:6px; font-size:.82rem; font-weight:700; color:var(--text3); text-decoration:none; padding:7px 14px; border:1px solid var(--border); border-radius:6px; background:var(--bg); transition:all .15s; }
.nav-link:hover { border-color:var(--accent); color:var(--accent); }
.nav-link.next { background:var(--accent); color:#fff; border-color:var(--accent); }
.nav-link.next:hover { background:#1a4f8a; }

footer { border-top:1px solid var(--border); padding:14px 28px; display:flex; justify-content:space-between; font-family:'Fira Code',monospace; font-size:10px; color:var(--text3); background:var(--surface); }
footer a { color:inherit; text-decoration:none; }

@media (max-width:600px) {
  .modo-grid { grid-template-columns:1fr; }
  .param-table tbody td:nth-child(2) { white-space:normal; }
}
</style>
</head>
<body>

<div id="prog" class="prog"></div>

<header class="topbar">
  <a class="tb-logo" href="../index.html">
    <div class="tb-logo-icon">🐍</div>
    Chatbots com Python
  </a>
  <div class="tb-nav">
    <a class="tb-btn" href="../index.html">⊞ índice</a>
    <span class="tb-lesson">aula 04 - prompts avançados</span>
    <a class="tb-btn" href="aula3.php">←</a>
    <a class="tb-btn next" href="revisao.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">aula 04</span>
    <h1>Controlando a IA: <em>parâmetros e prompts avançados</em></h1>
    <p>Na aula passada nós vimos que cada mensagem enviada ao GPT consome tokens, e que tokens custam dinheiro. Vimos também que o system prompt define quem o bot é e o que ele pode responder. Agora vamos ir além: nós vamos medir esse custo antes de gastar, e controlar com precisão como o GPT gera as respostas, não só o que ele responde.</p>
    <p>Pequenos ajustes nos parâmetros da chamada mudam completamente o comportamento do bot. A mesma pergunta pode receber uma resposta criativa e longa, ou direta e curtíssima, dependendo de como nós configuramos. Vamos ver isso na prática.</p>
  </div>

  <p>Sabemos que tokens custam dinheiro. Mas antes de medir, vale entender o que o GPT está medindo. Um token não é uma palavra inteira. É o pedaço em que o modelo divide o texto para processar. Pode ser um caractere só, pode ser uma palavra completa, pode ser metade de uma palavra. Espaços, pontuação, números e símbolos também entram na conta. Em inglês, a estimativa costuma ser 1 token para cada 4 caracteres ou 0,75 palavra. Em português, por causa dos acentos e das palavras mais longas, o número de tokens por palavra tende a ser um pouco maior. Aqui está a regra prática para guardar:</p>

  <div class="lousa">
    <div class="lousa-title">O que vira token</div>
    <div class="lousa-row"><span class="bul">◆</span><span>palavras comuns: geralmente <strong>1 token</strong> cada</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>palavras longas ou raras: podem virar <strong>2 ou mais tokens</strong></span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>espaços, pontuação e símbolos: <strong>também contam</strong></span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>imagens e arquivos: consomem <strong>muito mais</strong> do que texto simples</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>regra prática: <strong>1 token ≈ 3 a 4 caracteres</strong> em média</span></div>
  </div>

  <p>E atenção: em cada chamada ao GPT, os tokens de entrada incluem tudo que nós enviamos, o system prompt, o histórico da conversa e a pergunta do usuário. Os tokens de saída são os que o GPT gera para montar a resposta. Saída costuma custar mais por token do que entrada. Quanto maior o histórico acumulado, maior o custo de entrada a cada rodada.</p>

  <p>Com isso em mente, podemos nos perguntar: mas como saber, <em>antes</em> de enviar para a API, quantos tokens um texto vai consumir? É para isso que existe o <strong>tiktoken</strong>. Trata-se de uma biblioteca criada pela própria OpenAI que conta tokens localmente, sem fazer nenhuma requisição paga. Nós a usamos para medir textos antes de gastar.</p>

  <p>Para instalar, vamos abrir o terminal do VSCode e rodar:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">terminal</div>
    </div>
    <pre>pip install tiktoken</pre>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Instalando o tiktoken no terminal</div>
    <img src="img/072.png" alt="Instalação do tiktoken no terminal">
  </div>

  <p>Com a biblioteca instalada, o código para contar tokens fica assim:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">025_Exercicio.py</div>
    </div>
    <pre><span class="kw">import</span> tiktoken

<span class="vr">texto</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Digite o texto para contar tokens: "</span>)
<span class="vr">enc</span> <span class="op">=</span> tiktoken.<span class="fn">encoding_for_model</span>(<span class="st">"gpt-4o-mini"</span>)
<span class="vr">tokens</span> <span class="op">=</span> <span class="vr">enc</span>.<span class="fn">encode</span>(<span class="vr">texto</span>)
<span class="fn">print</span>(<span class="st">f"Tokens: {len(tokens)}"</span>)
<span class="fn">print</span>(<span class="st">f"Caracteres: {len(texto)}"</span>)
<span class="fn">print</span>(<span class="st">f"Razão (chars/token): {len(texto)/len(tokens):.1f}"</span>)</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>import tiktoken</td>
      <td><strong>Importa a biblioteca de contagem de tokens.</strong> Ela processa tudo localmente, sem internet, usando as mesmas regras internas que o GPT usa para dividir o texto em pedacinhos.</td>
    </tr>
    <tr>
      <td>encoding_for_model("gpt-4o-mini")</td>
      <td><strong>Carrega as regras de divisão do modelo específico.</strong> Cada modelo pode fatiar o texto de forma ligeiramente diferente. Passamos <code>"gpt-4o-mini"</code> para garantir que a contagem seja idêntica à que acontece na API quando enviamos a mensagem de verdade.</td>
    </tr>
    <tr>
      <td>enc.encode(texto)</td>
      <td><strong>Divide o texto em tokens e retorna uma lista.</strong> Cada item da lista é um número que representa um fragmento do texto. O <code>len()</code> dessa lista nos diz exatamente quantos tokens o texto possui.</td>
    </tr>
    <tr>
      <td>len(texto)/len(tokens)</td>
      <td><strong>Calcula a razão entre caracteres e tokens.</strong> Isso nos permite comparar com a estimativa que vimos na aula passada (1 token ≈ 3 a 4 caracteres) e ver se ela se confirma para textos em português.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Rodando o contador de tokens</div>
    <img src="img/073.png" alt="Executando o contador de tokens">
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Mas pra que contar antes de enviar? Não é mais fácil só enviar e ver depois?</div>
  </div>

  <p>Faz sentido pensar assim no início. Mas pensa no seguinte: em projetos reais, os usuários podem mandar mensagens enormes, parágrafos inteiros, textos copiados de algum lugar. Cada mensagem dessas custa muito mais do que o esperado. Com o tiktoken, nós conseguimos verificar o tamanho antes de gastar e, se necessário, avisar o usuário: <em>"sua mensagem está muito longa, por favor resuma"</em>. Custo controlado antes de acontecer.</p>

  <div class="dica">
    <strong>Dica prática:</strong> o tiktoken também é útil para medir o tamanho do seu próprio system prompt. Um system prompt de 300 tokens é reenviado em <em>toda</em> chamada da conversa. Se a sessão tem 20 trocas, ele sozinho já gerou 6.000 tokens de entrada só de existir. Saber isso ajuda a calibrar o quanto detalhar o prompt sem desperdiçar dinheiro.
  </div>

  <p>Agora que nós sabemos medir tokens, vamos falar dos <strong>parâmetros</strong> que controlam como o GPT gera as respostas. Até agora, nas chamadas que fizemos, passamos apenas o modelo e as mensagens. Mas a API aceita vários outros ajustes que mudam completamente o comportamento da IA.</p>

  <p>Pensa assim: o system prompt diz ao GPT <em>o que fazer</em>. Os parâmetros controlam <em>como ele executa</em> isso, com que criatividade, com que tamanho de resposta, com que variedade de palavras.</p>

  <table class="param-table">
    <thead>
      <tr>
        <th>parâmetro</th>
        <th>valores</th>
        <th>o que controla</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>temperature</td>
        <td>0.0 a 2.0</td>
        <td><strong>A criatividade da resposta.</strong> Zero é previsível e focado: o GPT sempre escolhe a palavra mais provável. Dois é caótico e inventivo. Para bots técnicos ou de suporte, o ideal fica entre 0.1 e 0.3. Para escrita criativa, entre 0.7 e 1.2.</td>
      </tr>
      <tr>
        <td>max_tokens</td>
        <td>1 a 16384</td>
        <td><strong>O tamanho máximo da resposta.</strong> O GPT para de gerar quando atinge esse número, mesmo que a frase não tenha terminado. É um limite físico, não uma instrução, então nós usamos junto com o prompt para evitar cortes bruscos.</td>
      </tr>
      <tr>
        <td>top_p</td>
        <td>0.0 a 1.0</td>
        <td><strong>A diversidade do vocabulário.</strong> Com 1.0 o GPT considera todas as palavras possíveis. Com 0.1 só considera as mais prováveis. Funciona em conjunto com temperature. Não é comum usar os dois com valores altos ao mesmo tempo.</td>
      </tr>
      <tr>
        <td>frequency_penalty</td>
        <td>-2.0 a 2.0</td>
        <td><strong>Penalidade por repetição de palavras.</strong> Valores positivos reduzem a chance de a mesma palavra aparecer várias vezes numa resposta. Torna o texto mais natural e variado.</td>
      </tr>
      <tr>
        <td>presence_penalty</td>
        <td>-2.0 a 2.0</td>
        <td><strong>Incentivo para abordar novos temas.</strong> Valores positivos fazem o GPT preferir assuntos que ainda não foram mencionados na conversa. Evita que o bot fique circulando na mesma ideia sem sair dela.</td>
      </tr>
    </tbody>
  </table>

  <div class="lousa">
    <div class="lousa-title">Resumo rápido dos parâmetros</div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>temperature alta</strong> = mais criativo, menos previsível</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>temperature baixa</strong> = mais focado, mais consistente</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>max_tokens baixo</strong> = resposta curta (cuidado com corte no meio)</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>frequency_penalty alto</strong> = menos repetição de palavras</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>presence_penalty alto</strong> = aborda mais temas diferentes</span></div>
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Se eu colocar temperature=0, o GPT sempre vai dar exatamente a mesma resposta?</div>
  </div>

  <p>Quase isso. Com temperature zero o GPT escolhe sempre a palavra mais provável a cada passo, então as respostas ficam muito parecidas para a mesma pergunta. Não são 100% idênticas por outros fatores internos, mas a variação é mínima. Para chatbots de suporte técnico ou atendimento, isso é ótimo: nós queremos consistência, não surpresa.</p>

  <div class="atencao">
    <strong>Atenção com max_tokens muito baixo:</strong> se nós definirmos 50 tokens e a resposta natural teria 80, o GPT simplesmente para no meio da frase. O ideal é sempre combinar o parâmetro com uma instrução no system prompt, por exemplo: <em>"responda em no máximo 2 frases curtas"</em>. O prompt convence a IA a ser breve; o max_tokens é o limite físico de segurança caso ela não obedeça.
  </div>

  <p>Uma forma muito prática de usar esses parâmetros é criar <strong>modos de resposta</strong> para o chatbot. Dependendo do contexto, nós precisamos de configurações bem diferentes. Um bot criativo de conteúdo não pode ter os mesmos ajustes de um bot de produção com custo controlado. Veja como os parâmetros se traduzem em três perfis diferentes:</p>

  <div class="modo-grid">
    <div class="modo-card modo-criativo">
      <span class="modo-label">🎨 modo criativo</span>
      <p><code>temperature=1.2</code><br>
         <code>top_p=0.95</code><br>
         <code>max_tokens=300</code><br><br>
         Respostas imaginativas, com vocabulário variado. Bom para geração de texto, histórias, brainstorm.</p>
    </div>
    <div class="modo-card modo-tecnico">
      <span class="modo-label">🔧 modo técnico</span>
      <p><code>temperature=0.2</code><br>
         <code>top_p=0.8</code><br>
         <code>max_tokens=500</code><br><br>
         Preciso e detalhado. Bom para explicações técnicas, análise de código, documentação.</p>
    </div>
    <div class="modo-card modo-economico">
      <span class="modo-label">💰 modo econômico</span>
      <p><code>temperature=0.2</code><br>
         <code>max_tokens=80</code><br>
         <code>frequency_penalty=0.4</code><br><br>
         Respostas curtas e diretas. Ideal para produção com custo controlado.</p>
    </div>
  </div>

  <p>Vamos implementar os três modos num único código. Observe como o system prompt e os parâmetros trabalham juntos: o prompt define a intenção, os parâmetros garantem os limites técnicos.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">026_Exercicio.py</div>
    </div>
    <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv
<span class="kw">import</span> httpx

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">modos</span> <span class="op">=</span> {
    <span class="st">"criativo"</span>: {
        <span class="st">"system"</span>: <span class="st">"Você é um assistente criativo e expressivo. Use metáforas, exemplos coloridos e linguagem envolvente."</span>,
        <span class="st">"temperature"</span>: <span class="nm">1.2</span>,
        <span class="st">"max_tokens"</span>: <span class="nm">300</span>,
        <span class="st">"top_p"</span>: <span class="nm">0.95</span>
    },
    <span class="st">"tecnico"</span>: {
        <span class="st">"system"</span>: <span class="st">"Você é um assistente técnico e preciso. Dê explicações detalhadas com exemplos práticos quando necessário."</span>,
        <span class="st">"temperature"</span>: <span class="nm">0.2</span>,
        <span class="st">"max_tokens"</span>: <span class="nm">500</span>,
        <span class="st">"top_p"</span>: <span class="nm">0.8</span>
    },
    <span class="st">"economico"</span>: {
        <span class="st">"system"</span>: <span class="st">"Você é um assistente direto e objetivo. Responda em no máximo 2 frases curtas. Sem enrolação."</span>,
        <span class="st">"temperature"</span>: <span class="nm">0.2</span>,
        <span class="st">"max_tokens"</span>: <span class="nm">80</span>,
        <span class="st">"frequency_penalty"</span>: <span class="nm">0.4</span>
    }
}

<span class="fn">print</span>(<span class="st">"Modos disponíveis: criativo | tecnico | economico"</span>)
<span class="vr">escolha</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Escolha o modo: "</span>).<span class="fn">strip</span>().<span class="fn">lower</span>()

<span class="kw">if</span> <span class="vr">escolha</span> <span class="kw">not in</span> <span class="vr">modos</span>:
    <span class="fn">print</span>(<span class="st">"Modo inválido. Usando 'tecnico' como padrão."</span>)
    <span class="vr">escolha</span> <span class="op">=</span> <span class="st">"tecnico"</span>

<span class="vr">config</span> <span class="op">=</span> <span class="vr">modos</span>[<span class="vr">escolha</span>]
<span class="vr">mensagens</span> <span class="op">=</span> [{<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="vr">config</span>[<span class="st">"system"</span>]}]

<span class="fn">print</span>(<span class="st">f"\nModo '{escolha}' ativado. Digite 'sair' para encerrar.\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">pergunta</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"Bot: Até mais!"</span>)
        <span class="kw">break</span>
    <span class="kw">if not</span> <span class="vr">pergunta</span>:
        <span class="kw">continue</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">pergunta</span>})

    <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
        <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
        <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
        <span class="vr">temperature</span><span class="op">=</span><span class="vr">config</span>[<span class="st">"temperature"</span>],
        <span class="vr">max_tokens</span><span class="op">=</span><span class="vr">config</span>[<span class="st">"max_tokens"</span>],
        <span class="vr">top_p</span><span class="op">=</span><span class="vr">config</span>.<span class="fn">get</span>(<span class="st">"top_p"</span>, <span class="nm">1.0</span>),
        <span class="vr">frequency_penalty</span><span class="op">=</span><span class="vr">config</span>.<span class="fn">get</span>(<span class="st">"frequency_penalty"</span>, <span class="nm">0.0</span>)
    )

    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">texto</span>, <span class="st">"\n"</span>)

    <span class="cm"># Limita o histórico para controlar o custo</span>
    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>modos = {...}</td>
      <td><strong>Um dicionário que centraliza as configurações de cada modo.</strong> Em vez de três arquivos separados, nós colocamos tudo num lugar só. Cada chave é o nome do modo e o valor é outro dicionário com o system prompt e os parâmetros daquele modo.</td>
    </tr>
    <tr>
      <td>config = modos[escolha]</td>
      <td><strong>Seleciona as configurações do modo escolhido.</strong> A partir daqui, <code>config</code> é o dicionário daquele modo específico. Nós acessamos os valores via <code>config["temperature"]</code>, <code>config["max_tokens"]</code> e assim por diante.</td>
    </tr>
    <tr>
      <td>config.get("top_p", 1.0)</td>
      <td><strong>Lê um valor do dicionário com fallback.</strong> O método <code>.get()</code> retorna o valor da chave se ela existir, ou o segundo argumento caso ela não exista. Assim o modo econômico não precisa ter <code>top_p</code> declarado: o código assume 1.0 automaticamente.</td>
    </tr>
    <tr>
      <td>mensagens[0] + mensagens[-9:]</td>
      <td><strong>Limita o histórico a 10 mensagens.</strong> O <code>mensagens[0]</code> é sempre o system prompt, que não pode ser descartado. O <code>mensagens[-9:]</code> pega as últimas 9 trocas. Resultado: no máximo 10 itens sempre, memória funcional sem custo crescente.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Testando o modo Criativo e Economico</div>
    <img src="img/074.png" alt="Teste do modo criativo">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> A mesma pergunta no modo Técnico</div>
    <img src="img/075.png" alt="A mesma pergunta no modo econômico">
  </div>

  <p>Perceba a diferença: a mesma pergunta, o mesmo modelo, o mesmo mecanismo de memória. Só mudaram temperature, max_tokens e o system prompt. O resultado é completamente diferente em tamanho, estilo e custo.</p>

  <p>Mas repara numa coisa: em todos os três modos, o system prompt também mudou. Não adiantaria nada ter os parâmetros perfeitos se o texto do prompt fosse vago. Os dois trabalham juntos, e um prompt mal escrito compromete qualquer configuração. Na aula passada nós escrevemos os primeiros, agora vamos olhar para eles com mais cuidado. </p>

  <p>Um prompt eficaz normalmente combina quatro elementos principais: contexto, tarefa, formato e restrições.

  <p>Contexto define o cenário em que o chatbot vai atuar. Aqui, é importante deixar claro quem é o bot, para quem ele está falando, qual é o assunto da conversa e em que situação aquela interação acontece. Quanto mais claro for esse contexto, maior a chance de a resposta sair adequada ao público e ao objetivo. </p>

  <p>Tarefa explica exatamente o que o chatbot deve fazer. Não basta dizer apenas o tema. É preciso orientar qual ação se espera dele, como responder, até onde aprofundar e, principalmente, o que ele não deve fazer. Isso evita respostas vagas, fora do foco ou inadequadas. </p>

  <p>Formato determina como a resposta deve ser entregue. Você pode definir, por exemplo, se a saída deve vir em lista, em parágrafo, em etapas, em tabela, ou em tópicos curtos. Também pode limitar o tamanho da resposta, indicando número máximo de linhas, palavras ou itens. Esse ponto é importante para garantir padronização e clareza. </p>

  <p>Restrições funcionam como limites e regras de comportamento. Nessa parte, vale especificar o tom da resposta, o idioma, o escopo do assunto, o nível de formalidade, o que deve ser evitado e até quais tipos de pedido o chatbot deve recusar de forma educada. As restrições ajudam a manter consistência, segurança e aderência ao objetivo da conversa. </p>

  <div class="lousa">
    <div class="lousa-title">Prompt eficaz = Contexto + Tarefa + Formato + Restrições</div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Contexto:</strong> quem é o bot? para quem ele fala? em que situação?</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Tarefa:</strong> o que ele deve fazer? o que ele não deve fazer?</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Formato:</strong> lista? parágrafo? número máximo de palavras ou linhas?</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Restrições:</strong> tom, idioma, escopo, o que recusar educadamente.</span></div>
  </div>

  <p>Veja a diferença na prática. Os dois prompts abaixo são para o mesmo bot de suporte técnico:</p>

  <div class="aviso">
    <strong>Prompt fraco:</strong> "Você é um assistente. Responda perguntas sobre tecnologia."<br><br>
    O problema: muito vago. O GPT vai responder qualquer coisa sobre tecnologia, no tom que quiser, no tamanho que quiser, em qualquer idioma, sem recusar nada fora do escopo.
  </div>

  <div class="dica">
    <strong>Prompt forte:</strong> "Você é o assistente virtual da TechFix, empresa de suporte técnico para pequenas empresas. Responda apenas perguntas sobre computadores, internet, impressoras e celulares. Use linguagem simples, sem jargão técnico. Se a pergunta for fora desse escopo, diga educadamente que só pode ajudar com suporte técnico. Responda sempre em português. Máximo de 3 parágrafos por resposta."
  </div>

  <p>O segundo prompt não é mais bonito, ele é mais <em>específico</em>. Quanto mais preciso o prompt, menos o GPT precisa adivinhar o que nós queremos, e menos tokens são desperdiçados em respostas fora do esperado.</p>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Posso colocar no prompt "dê uma resposta boa"?</div>
  </div>

  <p>Pode escrever, mas não vai adiantar muito. "Boa" é subjetivo: o GPT não sabe o que nós consideramos bom. O mesmo vale para "bonito", "adequado", "interessante". Em vez disso, nós usamos termos mensuráveis: <em>"responda em no máximo 2 frases"</em>, <em>"use linguagem formal"</em>, <em>"inclua sempre um exemplo prático"</em>. Concreto funciona; subjetivo não.</p>


  <!-- COFFEE BREAK -->
  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa para o café!</h3>
    <p>Levanta, respira, e quando voltarmos colocaremos a mão no código de verdade.</p>
  </div>

  <p>Voltou? Pronto para continuar? Estou ansiosa para fazermos mais alguns testes.</p>


  <p>Há dois elementos que todo chatbot em produção precisa ter e que nós ainda não vimos: <strong>tratamento de erros</strong> e <strong>monitoramento do uso real de tokens</strong>.</p>

  <p>Nos códigos anteriores, se a API falhar, por crédito esgotado, internet caída ou chave inválida, o programa trava com uma mensagem de erro feia e para de funcionar. Em produção isso é inaceitável. A solução é o bloco <code>try/except</code>. Pensa nele como um "plano B": nós tentamos executar o código normal e, se algo der errado, o programa vai para o plano B em vez de travar.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">estrutura do try/except</div>
    </div>
    <pre><span class="kw">try</span>:
    <span class="cm"># código que pode falhar</span>
    <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(...)
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>

<span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
    <span class="fn">print</span>(<span class="st">f"Erro na API: {e}"</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Desculpe, houve um erro. Tente novamente."</span></pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>try:</td>
      <td><strong>Bloco que o Python tenta executar.</strong> Se tudo correr bem, o <code>except</code> é ignorado completamente. Se qualquer linha dentro do <code>try</code> lançar um erro, o Python pula imediatamente para o <code>except</code>, sem travar.</td>
    </tr>
    <tr>
      <td>except Exception as e:</td>
      <td><strong>Captura qualquer tipo de erro e guarda o detalhe na variável <code>e</code>.</strong> <code>Exception</code> é a classe base de todos os erros em Python. O <code>as e</code> nos permite imprimir a mensagem de erro para entender o que aconteceu, sem o programa encerrar sozinho.</td>
    </tr>
  </table>

  <p>Os erros mais comuns que nós vamos encontrar ao chamar a API são estes três:</p>

  <div class="atencao">
    <strong>AuthenticationError</strong> — chave inválida ou mal copiada. Verifique se o arquivo <code>.env</code> está na pasta certa e se a chave foi copiada sem espaços extras.<br><br>
    <strong>RateLimitError</strong> — créditos esgotados ou muitas chamadas por minuto. Se os créditos acabaram, é preciso recarregar no painel da OpenAI.<br><br>
    <strong>APIConnectionError</strong> — sem internet ou problema de rede. O código não conseguiu chegar nos servidores da OpenAI.
  </div>

  <p>Agora o segundo elemento. A API retorna no objeto de resposta um campo chamado <code>usage</code>, que informa exatamente quantos tokens foram consumidos naquela chamada. Não uma estimativa: o número real, gerado pela própria OpenAI depois do processamento.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">como ler o uso real de tokens</div>
    </div>
    <pre><span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(...)

<span class="fn">print</span>(<span class="st">"Tokens de entrada:"</span>, <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">prompt_tokens</span>)
<span class="fn">print</span>(<span class="st">"Tokens de saída:  "</span>, <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">completion_tokens</span>)
<span class="fn">print</span>(<span class="st">"Total:            "</span>, <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">total_tokens</span>)</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>resposta.usage</td>
      <td><strong>Objeto que a API devolve com o consumo real da chamada.</strong> Ele existe dentro de toda resposta, mesmo que nós não pedíssemos. Basta acessá-lo depois de receber a resposta.</td>
    </tr>
    <tr>
      <td>prompt_tokens</td>
      <td><strong>Tokens de entrada consumidos nessa chamada.</strong> Inclui o system prompt, todo o histórico e a pergunta atual. Vai crescendo a cada rodada porque o histórico cresce junto, até o limite que nós definimos.</td>
    </tr>
    <tr>
      <td>completion_tokens</td>
      <td><strong>Tokens de saída gerados pelo GPT.</strong> São os tokens que a IA criou para montar a resposta. Custam mais por unidade do que os de entrada.</td>
    </tr>
  </table>

  <p>Com essas duas peças, o <code>try/except</code> e o <code>usage</code>, vamos montar o chatbot econômico completo, como ficaria num projeto real. Nós acumulamos os tokens de cada chamada e mostramos o custo total da sessão quando o usuário encerrar:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">027_Exercicio.py</div>
    </div>
    <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv
<span class="kw">import</span> httpx

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">mensagens</span> <span class="op">=</span> [
    {
        <span class="st">"role"</span>: <span class="st">"system"</span>,
        <span class="st">"content"</span>: (
            <span class="st">"Você é um assistente direto e objetivo. "</span>
            <span class="st">"Responda de forma curta, clara e sem enrolação. "</span>
            <span class="st">"Evite repetir palavras e frases. "</span>
            <span class="st">"Seja eficiente e econômico nas respostas."</span>
        )
    }
]

<span class="vr">total_entrada</span> <span class="op">=</span> <span class="nm">0</span>
<span class="vr">total_saida</span>   <span class="op">=</span> <span class="nm">0</span>

<span class="fn">print</span>(<span class="st">"Chatbot iniciado. Digite 'sair' para encerrar.\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">pergunta</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"\n-- Resumo da sessão --"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de entrada : {total_entrada}"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de saída   : {total_saida}"</span>)
        <span class="fn">print</span>(<span class="st">f"Total             : {total_entrada + total_saida}"</span>)
        <span class="vr">custo</span> <span class="op">=</span> (<span class="vr">total_entrada</span> <span class="op">*</span> <span class="nm">0.00000015</span>) <span class="op">+</span> (<span class="vr">total_saida</span> <span class="op">*</span> <span class="nm">0.0000006</span>)
        <span class="fn">print</span>(<span class="st">f"Custo estimado    : U${custo:.6f}"</span>)
        <span class="fn">print</span>(<span class="st">"----------------------"</span>)
        <span class="kw">break</span>

    <span class="kw">if not</span> <span class="vr">pergunta</span>:
        <span class="kw">continue</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">pergunta</span>})

    <span class="kw">try</span>:
        <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">80</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.2</span>,
            <span class="vr">frequency_penalty</span><span class="op">=</span><span class="nm">0.4</span>,
            <span class="vr">presence_penalty</span><span class="op">=</span><span class="nm">0.2</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
        <span class="vr">total_entrada</span> <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">prompt_tokens</span>
        <span class="vr">total_saida</span>   <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">completion_tokens</span>

    <span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
        <span class="fn">print</span>(<span class="st">f"Erro na API: {e}"</span>)
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Desculpe, houve um erro ao processar sua mensagem."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">texto</span>, <span class="st">"\n"</span>)

    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>total_entrada = 0<br>total_saida = 0</td>
      <td><strong>Contadores acumulados da sessão.</strong> São iniciados fora do loop e somados a cada chamada bem-sucedida. No final, quando o usuário digitar "sair", eles revelam o custo total da conversa inteira.</td>
    </tr>
    <tr>
      <td>total_entrada += resposta.usage.prompt_tokens</td>
      <td><strong>Acumula os tokens reais de entrada a cada chamada.</strong> O operador <code>+=</code> soma o valor atual ao contador. O <code>prompt_tokens</code> inclui o system prompt, o histórico e a pergunta atual juntos.</td>
    </tr>
    <tr>
      <td>total_saida += resposta.usage.completion_tokens</td>
      <td><strong>Acumula os tokens reais de saída.</strong> São os tokens que o GPT gerou para montar a resposta. Custam mais por unidade do que os de entrada.</td>
    </tr>
    <tr>
      <td>custo = (entrada * 0.00000015) + (saida * 0.0000006)</td>
      <td><strong>Calcula o custo estimado em dólares.</strong> Os valores são as tarifas atuais do gpt-4o-mini: U$0,15 por milhão de tokens de entrada e U$0,60 por milhão de saída. O resultado aparece com 6 casas decimais porque os valores por sessão são bem pequenos.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Chatbot rodando com monitoramento ativo</div>
    <img src="img/076.png" alt="Chatbot econômico em execução">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Resumo de tokens e custo ao digitar "sair"</div>
    <img src="img/077.png" alt="Resumo da sessão com tokens e custo">
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Por que o custo estimado aqui pode ser diferente do que o tiktoken indicaria?</div>
  </div>

  <p>Boa pergunta. O tiktoken estima os tokens de uma string isolada. Mas o <code>usage</code> da API mede o custo real da chamada inteira, que inclui o system prompt, o histórico acumulado e a formatação interna que o GPT usa. Então o <code>usage</code> é sempre mais preciso para calcular custo. O tiktoken é útil para estimar antes de enviar; o <code>usage</code> é o número que vai para a fatura.</p>

  <p>Agora é a sua vez.</p>


  <!-- EXERCÍCIO 028 - aluno faz sozinho -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 028 - bot temático com custo</span>
    <h3>Assistente de pet shop com monitoramento de sessão <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Crie o arquivo <code>028_Exercicio.py</code> com um assistente virtual de uma pet shop chamada MiauWoof, especializada em cães e gatos</li>
      <li>Escreva o system prompt com Contexto + Tarefa + Formato + Restrições: o bot responde apenas sobre produtos, banho e tosa, e cuidados com pets, com tom carinhoso e no máximo 2 frases por resposta</li>
      <li>Adicione os contadores <code>total_entrada</code> e <code>total_saida</code> acumulando com <code>resposta.usage</code> a cada chamada</li>
      <li>Ao digitar "sair", exiba o resumo da sessão com tokens de entrada, saída, total e custo estimado</li>
      <li>Teste com pelo menos 3 perguntas dentro do escopo e 2 fora, o bot deve recusar educadamente as de fora</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:12px 0 8px;display:block">// assistente da MiauWoof com monitoramento de custo</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">028_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv
<span class="kw">import</span> httpx

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">mensagens</span> <span class="op">=</span> [
    {
        <span class="st">"role"</span>: <span class="st">"system"</span>,
        <span class="st">"content"</span>: (
            <span class="cm"># CONTEXTO</span>
            <span class="st">"Você é a assistente virtual da MiauWoof, pet shop especializada em cães e gatos. "</span>
            <span class="cm"># TAREFA</span>
            <span class="st">"Responda apenas sobre produtos, serviços de banho e tosa, e cuidados com pets. "</span>
            <span class="st">"Para assuntos fora desse escopo, diga que só entende de pets. "</span>
            <span class="cm"># FORMATO</span>
            <span class="st">"Responda em no máximo 2 frases. "</span>
            <span class="cm"># RESTRIÇÕES</span>
            <span class="st">"Use tom carinhoso e divertido. Responda sempre em português."</span>
        )
    }
]

<span class="vr">total_entrada</span> <span class="op">=</span> <span class="nm">0</span>
<span class="vr">total_saida</span>   <span class="op">=</span> <span class="nm">0</span>

<span class="fn">print</span>(<span class="st">"MiauWoof: Olá! Como posso ajudar seu pet hoje? 🐾"</span>)
<span class="fn">print</span>(<span class="st">"(Digite 'sair' para encerrar)\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">pergunta</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"\n-- Resumo da sessão --"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de entrada : {total_entrada}"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de saída   : {total_saida}"</span>)
        <span class="fn">print</span>(<span class="st">f"Total             : {total_entrada + total_saida}"</span>)
        <span class="vr">custo</span> <span class="op">=</span> (<span class="vr">total_entrada</span> <span class="op">*</span> <span class="nm">0.00000015</span>) <span class="op">+</span> (<span class="vr">total_saida</span> <span class="op">*</span> <span class="nm">0.0000006</span>)
        <span class="fn">print</span>(<span class="st">f"Custo estimado    : U${custo:.6f}"</span>)
        <span class="fn">print</span>(<span class="st">"----------------------"</span>)
        <span class="fn">print</span>(<span class="st">"MiauWoof: Volte sempre! 🐾"</span>)
        <span class="kw">break</span>

    <span class="kw">if not</span> <span class="vr">pergunta</span>:
        <span class="kw">continue</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">pergunta</span>})

    <span class="kw">try</span>:
        <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">80</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.6</span>,
            <span class="vr">frequency_penalty</span><span class="op">=</span><span class="nm">0.3</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
        <span class="vr">total_entrada</span> <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">prompt_tokens</span>
        <span class="vr">total_saida</span>   <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">completion_tokens</span>

    <span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
        <span class="fn">print</span>(<span class="st">f"Erro: {e}"</span>)
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não consegui processar sua pergunta. Tente novamente."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="fn">print</span>(<span class="st">f"MiauWoof: {texto}\n"</span>)

    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 029 - aluno faz sozinho -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 029 - bot híbrido</span>
    <h3>Chatbot que decide quando usar a IA <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Crie o arquivo <code>029_Exercicio.py</code> com um bot de atendimento de uma academia chamada FitClub</li>
      <li>Crie um dicionário de respostas fixas para as perguntas mais comuns: horário de funcionamento, preço da mensalidade e endereço. Essas perguntas o bot responde diretamente, sem chamar a API</li>
      <li>Para qualquer outra pergunta que não esteja no dicionário, o bot chama o GPT com um system prompt sobre a academia</li>
      <li>Use <code>try/except</code> na chamada à API e mantenha o histórico limitado a 10 mensagens</li>
      <li>Teste com perguntas do dicionário e com perguntas livres para confirmar que cada caminho funciona</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:12px 0 8px;display:block">// bot híbrido da FitClub</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">029_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv
<span class="kw">import</span> httpx

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="cm"># Respostas fixas - não gastam tokens</span>
<span class="vr">respostas_fixas</span> <span class="op">=</span> {
    <span class="st">"horario"</span>:    <span class="st">"FitClub: Funcionamos de segunda a sábado, das 6h às 22h."</span>,
    <span class="st">"horário"</span>:    <span class="st">"FitClub: Funcionamos de segunda a sábado, das 6h às 22h."</span>,
    <span class="st">"preco"</span>:      <span class="st">"FitClub: Mensalidade básica R$89 e plano completo R$149."</span>,
    <span class="st">"preço"</span>:      <span class="st">"FitClub: Mensalidade básica R$89 e plano completo R$149."</span>,
    <span class="st">"mensalidade"</span>:<span class="st">"FitClub: Mensalidade básica R$89 e plano completo R$149."</span>,
    <span class="st">"endereco"</span>:   <span class="st">"FitClub: Estamos na Rua das Palmeiras, 220 - Centro."</span>,
    <span class="st">"endereço"</span>:   <span class="st">"FitClub: Estamos na Rua das Palmeiras, 220 - Centro."</span>,
}

<span class="vr">mensagens</span> <span class="op">=</span> [
    {
        <span class="st">"role"</span>: <span class="st">"system"</span>,
        <span class="st">"content"</span>: (
            <span class="st">"Você é o assistente virtual da FitClub, academia de musculação e ginástica. "</span>
            <span class="st">"Responda dúvidas sobre treinos, modalidades e dicas de saúde. "</span>
            <span class="st">"Use linguagem motivadora. Responda em no máximo 3 frases."</span>
        )
    }
]

<span class="fn">print</span>(<span class="st">"FitClub: Olá! Como posso ajudar? 💪"</span>)
<span class="fn">print</span>(<span class="st">"(Digite 'sair' para encerrar)\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">pergunta</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"FitClub: Bons treinos! 🏋️"</span>)
        <span class="kw">break</span>
    <span class="kw">if not</span> <span class="vr">pergunta</span>:
        <span class="kw">continue</span>

    <span class="cm"># Verifica se alguma palavra-chave está na pergunta</span>
    <span class="vr">resposta_fixa</span> <span class="op">=</span> <span class="kw">None</span>
    <span class="kw">for</span> <span class="vr">chave</span> <span class="kw">in</span> <span class="vr">respostas_fixas</span>:
        <span class="kw">if</span> <span class="vr">chave</span> <span class="kw">in</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>():
            <span class="vr">resposta_fixa</span> <span class="op">=</span> <span class="vr">respostas_fixas</span>[<span class="vr">chave</span>]
            <span class="kw">break</span>

    <span class="kw">if</span> <span class="vr">resposta_fixa</span>:
        <span class="fn">print</span>(<span class="st">f"{resposta_fixa}\n"</span>)
    <span class="kw">else</span>:
        <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">pergunta</span>})
        <span class="kw">try</span>:
            <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
                <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
                <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
                <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">120</span>,
                <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.6</span>
            )
            <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
        <span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
            <span class="fn">print</span>(<span class="st">f"Erro: {e}"</span>)
            <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não consegui responder agora. Tente novamente."</span>

        <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
        <span class="fn">print</span>(<span class="st">f"FitClub: {texto}\n"</span>)

        <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
            <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 030 - aluno faz sozinho -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 030 - tudo junto</span>
    <h3>Bot completo do zero: modos, proteção e custo <span class="ex-diff diff-3">avançado</span></h3>
    <ol>
      <li>Crie o arquivo <code>030_Exercicio.py</code> com um assistente de uma escola de idiomas chamada LinguaViva</li>
      <li>Implemente dois modos: <strong>informativo</strong> (temperature 0.2, respostas sobre cursos e preços) e <strong>conversacional</strong> (temperature 0.8, para praticar inglês com o aluno de forma leve)</li>
      <li>Antes de enviar, use o tiktoken para bloquear mensagens com mais de 80 tokens, pedindo que o aluno seja mais breve</li>
      <li>Adicione <code>try/except</code> e contadores de <code>total_entrada</code> e <code>total_saida</code> com <code>resposta.usage</code></li>
      <li>Ao digitar "sair", mostre o resumo completo da sessão com tokens e custo estimado</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:12px 0 8px;display:block">// LinguaViva com dois modos, tiktoken, try/except e custo</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">030_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv
<span class="kw">import</span> httpx
<span class="kw">import</span> tiktoken

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">enc</span> <span class="op">=</span> tiktoken.<span class="fn">encoding_for_model</span>(<span class="st">"gpt-4o-mini"</span>)
<span class="vr">LIMITE_TOKENS</span> <span class="op">=</span> <span class="nm">80</span>

<span class="vr">modos</span> <span class="op">=</span> {
    <span class="st">"informativo"</span>: {
        <span class="st">"system"</span>: (
            <span class="st">"Você é o assistente da LinguaViva, escola de inglês e espanhol. "</span>
            <span class="st">"Responda apenas dúvidas sobre cursos, preços, horários e matrículas. "</span>
            <span class="st">"Use tom profissional. Responda em até 3 frases objetivas."</span>
        ),
        <span class="st">"temperature"</span>: <span class="nm">0.2</span>,
        <span class="st">"max_tokens"</span>: <span class="nm">150</span>
    },
    <span class="st">"conversacional"</span>: {
        <span class="st">"system"</span>: (
            <span class="st">"You are a friendly English conversation partner at LinguaViva school. "</span>
            <span class="st">"Help students practice English. Keep it simple and encouraging. "</span>
            <span class="st">"Respond in English, max 2 short sentences."</span>
        ),
        <span class="st">"temperature"</span>: <span class="nm">0.8</span>,
        <span class="st">"max_tokens"</span>: <span class="nm">100</span>
    }
}

<span class="fn">print</span>(<span class="st">"Modos disponíveis: informativo | conversacional"</span>)
<span class="vr">escolha</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Escolha o modo: "</span>).<span class="fn">strip</span>().<span class="fn">lower</span>()

<span class="kw">if</span> <span class="vr">escolha</span> <span class="kw">not in</span> <span class="vr">modos</span>:
    <span class="fn">print</span>(<span class="st">"Modo inválido. Usando 'informativo' como padrão."</span>)
    <span class="vr">escolha</span> <span class="op">=</span> <span class="st">"informativo"</span>

<span class="vr">config</span> <span class="op">=</span> <span class="vr">modos</span>[<span class="vr">escolha</span>]
<span class="vr">mensagens</span> <span class="op">=</span> [{<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="vr">config</span>[<span class="st">"system"</span>]}]

<span class="vr">total_entrada</span> <span class="op">=</span> <span class="nm">0</span>
<span class="vr">total_saida</span>   <span class="op">=</span> <span class="nm">0</span>

<span class="fn">print</span>(<span class="st">f"\nLinguaViva ({escolha}): Olá! Como posso ajudar?\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">pergunta</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="vr">pergunta</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"\n-- Resumo da sessão --"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de entrada : {total_entrada}"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de saída   : {total_saida}"</span>)
        <span class="fn">print</span>(<span class="st">f"Total             : {total_entrada + total_saida}"</span>)
        <span class="vr">custo</span> <span class="op">=</span> (<span class="vr">total_entrada</span> <span class="op">*</span> <span class="nm">0.00000015</span>) <span class="op">+</span> (<span class="vr">total_saida</span> <span class="op">*</span> <span class="nm">0.0000006</span>)
        <span class="fn">print</span>(<span class="st">f"Custo estimado    : U${custo:.6f}"</span>)
        <span class="fn">print</span>(<span class="st">"----------------------"</span>)
        <span class="kw">break</span>

    <span class="kw">if not</span> <span class="vr">pergunta</span>:
        <span class="kw">continue</span>

    <span class="cm"># Bloqueia mensagens longas antes de gastar tokens</span>
    <span class="vr">tokens_pergunta</span> <span class="op">=</span> <span class="fn">len</span>(<span class="vr">enc</span>.<span class="fn">encode</span>(<span class="vr">pergunta</span>))
    <span class="kw">if</span> <span class="vr">tokens_pergunta</span> <span class="op">></span> <span class="vr">LIMITE_TOKENS</span>:
        <span class="fn">print</span>(<span class="st">f"LinguaViva: Mensagem muito longa ({tokens_pergunta} tokens). Por favor, escreva de forma mais curta.\n"</span>)
        <span class="kw">continue</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">pergunta</span>})

    <span class="kw">try</span>:
        <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="vr">config</span>[<span class="st">"temperature"</span>],
            <span class="vr">max_tokens</span><span class="op">=</span><span class="vr">config</span>[<span class="st">"max_tokens"</span>]
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
        <span class="vr">total_entrada</span> <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">prompt_tokens</span>
        <span class="vr">total_saida</span>   <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">completion_tokens</span>
    <span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
        <span class="fn">print</span>(<span class="st">f"Erro: {e}"</span>)
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não foi possível responder agora. Tente novamente."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="fn">print</span>(<span class="st">f"LinguaViva: {texto}\n"</span>)

    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
        </div>
      </div>
    </div>
  </div>


  <!-- DOWNLOADS -->
  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">

      <a class="dl-item" href="arquivos/025_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">025_Exercicio.py</div>
          <div class="dl-desc">Contador de tokens com tiktoken - mede qualquer texto antes de enviar para a API</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/026_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">026_Exercicio.py</div>
          <div class="dl-desc">Chatbot com três modos: criativo, técnico e econômico, escolhidos no início da sessão</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/027_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">027_Exercicio.py</div>
          <div class="dl-desc">Exercício: chatbot com prompt estruturado, try/except e controle de histórico</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/028_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">028_Exercicio.py</div>
          <div class="dl-desc">Exercício: assistente da MiauWoof com system prompt estruturado e monitoramento de custo por sessão</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/029_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">029_Exercicio.py</div>
          <div class="dl-desc">Exercício: bot híbrido da FitClub com dicionário de respostas fixas e IA para o restante</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/030_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">030_Exercicio.py</div>
          <div class="dl-desc">Exercício: LinguaViva com dois modos, filtro de tokens, try/except e custo por sessão</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

    </div>
  </div>

  <div class="ready">
    <span class="re">🎉</span>
    <h2>Pronto para a Aula 5!</h2>
    <p>Na Aula 5 nós vamos dar um passo a mais. Nos vemos lá!</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="aula3.php">← Aula 3</a>
    <a class="nav-link next" href="revisao.php">Revisão →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>

<footer>
  <span>Chatbots com Python · aula 4</span>
  <span><a href="../index.html">← índice</a></span>
</footer>

<script>
const p = document.getElementById('prog');
window.addEventListener('scroll', () => {
  const h = document.documentElement.scrollHeight - window.innerHeight;
  p.style.width = (window.scrollY / h * 100) + '%';
});
function toggleAns(btn) {
  const body = btn.nextElementSibling;
  const open = body.classList.toggle('visible');
  btn.textContent = open ? '▼ ocultar solução' : '▶ ver uma possível solução';
}
</script>
</body>
</html>
