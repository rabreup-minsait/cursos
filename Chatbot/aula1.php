<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aula 1 - Chatbots com Python</title>
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

body {
  background: var(--bg);
  color: var(--text2);
  font-family: 'Nunito', system-ui, sans-serif;
  line-height: 1.85;
}

/* ── TOPBAR ── */
.topbar {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 0 28px;
  display: flex; align-items: center;
  justify-content: space-between;
  height: 48px;
  position: sticky; top: 0; z-index: 50;
}
.tb-logo {
  display: flex; align-items: center; gap: 8px;
  text-decoration: none;
  font-weight: 800; font-size: .85rem; color: var(--text);
}
.tb-logo-icon {
  width: 24px; height: 24px; background: var(--accent);
  border-radius: 5px; display: flex; align-items: center;
  justify-content: center; font-size: 12px;
}
.tb-nav { display: flex; align-items: center; gap: 4px; }
.tb-btn {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: .78rem; font-weight: 700; color: var(--text3);
  text-decoration: none; padding: 5px 10px;
  border: 1px solid var(--border); border-radius: 5px;
  background: var(--bg); transition: all .15s;
}
.tb-btn:hover { border-color: var(--accent); color: var(--accent); }
.tb-btn.next { background: var(--accent); color: #fff; border-color: var(--accent); }
.tb-btn.next:hover { background: #1a4f8a; }
.tb-lesson {
  font-family: 'Fira Code', monospace;
  font-size: 10.5px; color: var(--text3); letter-spacing:.06em;
  padding: 0 12px;
}

/* ── PROGRESS ── */
.prog { position:fixed; top:0; left:0; height:2px; background:var(--accent); z-index:100; width:0; transition:width .1s; }

/* ── LAYOUT ── */
.wrap { max-width: 680px; margin: 0 auto; padding: 44px 28px 90px; }

/* ── COVER ── */
.cover { margin-bottom: 52px; }
.cover-tag {
  font-family: 'Fira Code', monospace;
  font-size: 10px; letter-spacing:.2em; text-transform:uppercase;
  color: var(--text3); margin-bottom: 12px; display:block;
}
.cover h1 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.7rem, 3.5vw, 2.3rem);
  font-weight: 700; line-height: 1.2;
  color: var(--text); margin-bottom: 16px;
}
.cover h1 em { color: var(--accent); font-style: italic; }
.cover p { font-size: 1rem; color: var(--text2); line-height: 1.85; }

/* ── BODY TEXT ── */
p {
  font-size: .97rem; color: var(--text2);
  margin-bottom: 20px; line-height: 1.85;
}
p:last-child { margin-bottom: 0; }
strong { color: var(--text); font-weight: 700; }

code {
  font-family: 'Fira Code', monospace; font-size: .82em;
  background: var(--accent-lt);
  border: 1px solid rgba(31,95,166,.16);
  border-radius: 4px; padding: 1px 6px; color: var(--accent);
}

/* ── SECTION BREAK ── */
.sbreak {
  display: flex; align-items: center; gap: 14px;
  margin: 52px 0 36px;
  color: var(--text3);
  font-family: 'Fira Code', monospace;
  font-size: 10px; letter-spacing: .18em; text-transform: uppercase;
}
.sbreak::before, .sbreak::after {
  content: ''; flex: 1; height: 1px; background: var(--border);
}

/* ── LOUSA ── */
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
  font-size: .7rem; text-transform:uppercase; letter-spacing:.1em;
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
.lousa code {
  background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.18);
  color: #a8e8c0; font-size: .8em;
}

/* ── BUBBLE ── */
.bubble {
  display: flex; gap: 10px; align-items: flex-start;
  margin: 28px 0 8px;
}
.bubble-avatar {
  flex-shrink: 0; width: 32px; height: 32px;
  background: #f0a500; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; margin-top: 2px;
  box-shadow: 0 2px 6px rgba(240,165,0,.3);
}
.bubble-body {
  background: #fffbf0;
  border: 1.5px solid #f0c040;
  border-radius: 4px 14px 14px 14px;
  padding: 11px 15px;
  font-size: .9rem; color: #4a3800;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(240,165,0,.15);
  line-height: 1.65; max-width: 500px;
}

/* ── CALLOUTS ── */
.dica {
  border-left: 3px solid var(--accent);
  background: var(--accent-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #1a3a6a; line-height: 1.75;
}
.dica strong { color: #1a3a6a; font-weight: 800; }

.atencao {
  border-left: 3px solid var(--gold);
  background: var(--gold-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #5a3808; line-height: 1.75;
}
.atencao strong { color: #5a3808; font-weight: 800; }

.aviso {
  border-left: 3px solid var(--red);
  background: var(--red-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #6a1515; line-height: 1.75;
}
.aviso strong { color: #6a1515; font-weight: 800; }

/* ── CODE BLOCK ── */
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

/* ── TABELA DE ANOTAÇÃO ── */
.code-ann { margin:16px 0 24px; border-collapse:collapse; width:100%; }
.code-ann tr { border-bottom:1px solid var(--border); }
.code-ann tr:last-child { border-bottom:none; }
.code-ann td { padding:8px 10px; font-size:.85rem; vertical-align:top; line-height:1.65; }
.code-ann td:first-child {
  font-family:'Fira Code',monospace; font-size:.78rem; white-space:nowrap;
  color:var(--accent); background:var(--accent-lt);
  border-radius:4px; width:1%; padding:8px 12px;
}
.code-ann td:last-child { color:var(--text2); }
.code-ann td strong { color:var(--text); }

/* ── DIAGRAMA ── */
.flow { display:flex; align-items:center; justify-content:center; gap:0; margin:22px 0; flex-wrap:wrap; }
.fbox { background:var(--surface); border:1px solid var(--border); border-radius:7px; padding:10px 16px; text-align:center; min-width:100px; box-shadow:var(--shadow-sm); font-family:'Nunito',sans-serif; }
.fbox.hi { border-color:rgba(31,95,166,.4); background:var(--accent-lt); }
.fbox .fe { font-size:1.3rem; display:block; margin-bottom:3px; }
.fbox .fl { font-size:9.5px; color:var(--text3); text-transform:uppercase; letter-spacing:.08em; }
.fbox .fn2 { font-size:.8rem; font-weight:800; color:var(--text); }
.farrow { font-size:.9rem; color:#ccc8c2; padding:0 8px; }

/* ── BREAK ── */
.break { background:var(--gold-lt); border:1px solid rgba(160,104,32,.2); border-radius:8px; padding:18px 22px; text-align:center; margin:44px 0; }
.break .be { font-size:1.8rem; display:block; margin-bottom:6px; }
.break h3 { font-family:'Playfair Display',serif; color:var(--gold); font-size:1rem; font-style:normal; margin-bottom:4px; }
.break p { font-size:.83rem; color:#7a5010; margin:0; }

/* ── EXERCÍCIO ── */
.exercise { background:var(--surface); border:1.5px solid var(--accent); border-radius:8px; padding:20px 22px; margin:32px 0; box-shadow:var(--shadow-sm); }
.ex-tag { font-family:'Fira Code',monospace; font-size:9.5px; letter-spacing:.18em; color:var(--accent); text-transform:uppercase; margin-bottom:8px; display:block; }
.exercise h3 { font-family:'Playfair Display',serif; color:var(--text); font-size:1.05rem; margin-bottom:12px; }
.exercise p { font-size:.9rem; }
.exercise ol { padding-left:18px; font-size:.88rem; line-height:2.1; color:var(--text2); }
.ex-diff { font-family:'Fira Code',monospace; font-size:9px; letter-spacing:.12em; text-transform:uppercase; padding:2px 8px; border-radius:3px; margin-left:8px; }
.diff-1 { background:var(--green-lt); color:var(--green); }
.diff-2 { background:var(--gold-lt); color:var(--gold); }
.diff-3 { background:var(--red-lt); color:var(--red); }
.ex-ans { margin-top:14px; padding-top:14px; border-top:1px solid var(--border); }
.ex-ans-tag { font-family:'Fira Code',monospace; font-size:9.5px; letter-spacing:.15em; color:var(--green); text-transform:uppercase; margin-bottom:8px; display:block; }
.ex-ans-body { display:none; }
.ex-ans-body.visible { display:block; }
.btn-ans {
  display:inline-flex; align-items:center; gap:6px;
  font-family:'Fira Code',monospace; font-size:.75rem; font-weight:600;
  color:var(--green); background:var(--green-lt);
  border:1.5px solid rgba(13,110,80,.25); border-radius:5px;
  padding:6px 14px; cursor:pointer;
  transition:all .15s; margin-top:4px;
  letter-spacing:.03em;
}
.btn-ans:hover { background:#d0ece3; border-color:rgba(13,110,80,.5); }

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
.install-step img {
  width: 100%; display: block;
  border-radius: 0;
}
.install-step-desc {
  padding: 10px 16px;
  font-size: .85rem; color: var(--text2); line-height: 1.7;
  border-top: 1px solid var(--border);
}


/* ── DOWNLOADS ── */
.downloads { margin: 48px 0 32px; }
.downloads-title {
  font-family: 'Fira Code', monospace;
  font-size: 10px; letter-spacing: .18em; text-transform: uppercase;
  color: var(--text3); margin-bottom: 12px; display: block;
}
.dl-grid { display: flex; flex-direction: column; gap: 7px; }
.dl-item {
  display: flex; align-items: center; gap: 12px;
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 7px; padding: 10px 14px;
  text-decoration: none; color: inherit;
  box-shadow: var(--shadow-sm);
  transition: border-color .15s, box-shadow .15s;
}
.dl-item:hover { border-color: var(--accent); box-shadow: var(--shadow); }
.dl-icon { font-size: 1.1rem; flex-shrink: 0; }
.dl-info { flex: 1; }
.dl-name { font-family: 'Fira Code', monospace; font-size: .78rem; color: var(--accent); font-weight: 500; }
.dl-desc { font-size: .75rem; color: var(--text3); margin-top: 1px; }
.dl-badge {
  font-family: 'Fira Code', monospace; font-size: 9px;
  background: var(--accent-lt); color: var(--accent);
  border-radius: 4px; padding: 2px 8px; flex-shrink: 0;
}

/* ── READY ── */
.ready { background:var(--green-lt); border:1.5px solid rgba(13,110,80,.3); border-radius:8px; padding:26px; text-align:center; margin:48px 0; }
.ready .re { font-size:2rem; display:block; margin-bottom:10px; }
.ready h2 { font-family:'Playfair Display',serif; color:var(--green); font-size:1.25rem; margin:0 0 8px; }
.ready p { font-size:.88rem; color:#0a4535; margin:0; }

/* ── NAV BOTTOM ── */
.nav-bottom { display:flex; justify-content:space-between; margin-top:52px; padding-top:20px; border-top:1px solid var(--border); }
.nav-link { display:inline-flex; align-items:center; gap:6px; font-size:.82rem; font-weight:700; color:var(--text3); text-decoration:none; padding:7px 14px; border:1px solid var(--border); border-radius:6px; background:var(--bg); transition:all .15s; }
.nav-link:hover { border-color:var(--accent); color:var(--accent); }
.nav-link.next { background:var(--accent); color:#fff; border-color:var(--accent); }
.nav-link.next:hover { background:#1a4f8a; }

/* ── FOOTER ── */
footer { border-top:1px solid var(--border); padding:14px 28px; display:flex; justify-content:space-between; font-family:'Fira Code',monospace; font-size:10px; color:var(--text3); background:var(--surface); }
footer a { color:inherit; text-decoration:none; }
</style>
</head>
<body>

<div id="prog" class="prog"></div>

<header class="topbar">
  <a class="tb-logo" href="AulaChatbot.html">
    <div class="tb-logo-icon">🐍</div>
    Chatbots com Python
  </a>
  <div class="tb-nav">
    <a class="tb-btn" href="AulaChatbot.html">⊞ índice</a>
    <span class="tb-lesson">aula 01 · chatbot sem IA</span>
    <a class="tb-btn" href="nivelamento.php">←</a>
    <a class="tb-btn next" href="aula2.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">aula 01</span>
    <h1>Seu primeiro <em>chatbot de verdade</em></h1>
    <p>No nivelamento, você aprendeu a escrever funções, guardar informações em variáveis e tomar decisões com <code>if</code>. Agora vamos juntar tudo isso em algo que funciona como um chatbot de verdade: um programa que fica no ar, vê o que você digita e responde. Sem IA por enquanto, só código puro. E é assim que tem que ser. Não dá pra colocar o recheio antes de fazer a massa.</p>
  </div>

  <p>Antes de escrever qualquer coisa, pensa comigo: o que um chatbot faz, na prática? Ele fica esperando você digitar algo. Você digita. Ele processa. Ele responde. E aí fica esperando de novo. Infinitamente, até você decidir encerrar.</p>

  <p>Isso tem um nome em programação: <strong>loop</strong>. Um loop é um bloco de código que se repete. E o loop que vamos usar aqui é o <code>while True</code> que em português significa literalmente "enquanto verdadeiro", ou seja, repita para sempre. É exatamente o comportamento que a Alexa tem: ela fica te ouvindo sem parar, esperando você chamar.</p>

  <p>Vamos começar pelo chatbot mais simples possível. Seis linhas. Ele não faz nada inteligente, só repete o que você digitar, como aquele aplicativo do gatinho que fazia sucesso. O objetivo aqui não é impressionar: é entender a estrutura.</p>

  <p>Crie um novo arquivo Python no VSCode, <code>File</code> → <code>New File...</code> → <code>Python File</code> -> e chame de <code>006_Exercicio.py</code>. Digite o código abaixo:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">006_Exercicio.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)
        <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">user</span>)

<span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>while True:</td>
      <td><strong>O loop infinito.</strong> Enquanto a condição for verdadeira, e <code>True</code> é sempre verdadeiro, o bloco indentado abaixo se repete. O chatbot fica vivo enquanto o programa estiver rodando.</td>
    </tr>
    <tr>
      <td>user = input("Você: ")</td>
      <td><strong>Espera o usuário digitar algo</strong> e guarda o texto na variável <code>user</code>. O programa pausa aqui até o Enter ser pressionado, é o input do ciclo.</td>
    </tr>
    <tr>
      <td>print("Bot:", user)</td>
      <td><strong>Imprime a resposta no terminal.</strong> Por enquanto, a "resposta" é só repetir o que o usuário disse. Isso é o output do ciclo.</td>
    </tr>
  </table>


  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Resolução Exercício 6</div>
    <img src="img/040.png" alt="Resolução do Exercício 6">
  </div>


  <p>Execute, digite qualquer coisa e veja o bot repetir. O terminal ficará disponível sempre até que você feche ele ou force a parada. E isso é um problema nesse caso: <strong>o loop não tem saída.</strong></p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div>Teste  Exercício 6</div>
    <img src="img/041.png" alt="Teste do Exercício 6">
  </div>



  <div class="aviso">
    <strong>Terminal travado?</strong> Pressione <code>Ctrl + C</code> no terminal para forçar a parada. Ou clique no ícone de lixeira no canto do terminal para encerrá-lo completamente.
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">3</div>Parar Exercício 6</div>
    <img src="img/042.png" alt="Parar Exercício 6">
  </div>
<br>


  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Por que isso é um problema? O usuário não pode simplesmente fechar a janela?</div>
  </div>

  <p>Em casa, sim. Mas pensa num chatbot real, rodando num servidor de banco ou telecom, atendendo milhares de pessoas ao mesmo tempo. Se cada conversa ficar presa num loop infinito sem saída, o servidor acumula processos rodando à toa, consome memória, fica lento, e em casos graves, trava. Além disso, sem um ponto de encerramento definido, o chatbot não consegue enviar uma pesquisa de satisfação, registrar o fim do atendimento ou liberar recursos. O <code>break</code> não é detalhe: é parte da lógica do produto.</p>


  <p>A solução é o <code>break</code>. Ele interrompe o loop imediatamente quando executado. Vamos adicionar uma condição: se o usuário digitar "sair", o bot encerra.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">007_Exercicio.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="kw">break</span>

        <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">user</span>)

<span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>if user == "sair":</td>
      <td><strong>Verifica se o usuário digitou exatamente "sair".</strong> O operador <code>==</code> compara o valor da variável com o texto entre aspas. Se for igual, a condição é verdadeira.</td>
    </tr>
    <tr>
      <td>break</td>
      <td><strong>Interrompe o loop</strong> e o programa encerra. Sem o <code>break</code>, o <code>while True</code> nunca para por conta própria.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 7</div>
    <img src="img/043.png" alt="Resolução do Exercício 6">
  </div>


  <p>Teste agora. Digite qualquer coisa, ele repete. Digite "sair", ele encerra. Funciona! Mas tem um problema sutil: tente digitar "Sair" com S maiúsculo, ou "SAIR". Não funciona. O Python é case sensitive, <code>"sair"</code> e <code>"Sair"</code> são textos diferentes.</p>

 <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Exercício 7</div>
    <img src="img/044.png" alt="Teste do Exercício 7">
  </div>
<br>

  <p>Para o chatbot reconhecer "sair" independente de como o usuário digita, usamos o método <code>.lower()</code>. Ele converte qualquer texto para letras minúsculas antes de comparar. Vamos também adicionar uma mensagem de boas-vindas e uma de encerramento, dois detalhes simples que fazem muita diferença na experiência de quem usa.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">008_Exercício.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Digite 'sair' para encerrar.\n"</span>)
  <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Encerrando... até logo!"</span>)
            <span class="kw">break</span>

        <span class="fn">print</span>(<span class="st">f"Bot: Você disse: {</span><span class="vr">user</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>print(...\n)</td>
      <td><strong>O <code>\n</code> dentro de um texto cria uma linha em branco</strong> depois da mensagem. É um toque de organização visual no terminal.</td>
    </tr>
    <tr>
      <td>user.lower()</td>
      <td><strong>Converte o texto para minúsculas</strong> antes de comparar. Assim "Sair", "SAIR" e "sair" são tratados da mesma forma. O valor original de <code>user</code> não muda, o <code>.lower()</code> cria uma cópia convertida apenas para a comparação.</td>
    </tr>
    <tr>
      <td>if __name__ == "__main__":</td>
      <td><strong>Garante que o chatbot só inicia quando você rodar esse arquivo diretamente.</strong> Se outro arquivo importar esse código futuramente, a função não dispara sozinha. É uma boa prática que você vai ver em todo código Python profissional, e que já conhece do nivelamento.</td>
    </tr>
  </table>


  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 8</div>
    <img src="img/045.png" alt="Resolução do Exercício 8">
  </div>


  <div class="dica">
    O <code>.lower()</code> é um dos recursos mais usados em chatbots. Usuários digitam de formas imprevisíveis, maiúsculas, minúsculas, com acento, sem acento. Padronizar o input antes de processar é a primeira linha de defesa contra erros de interpretação.
  </div>


  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Exercício 8</div>
    <img src="img/046.png" alt="Teste do Exercício 8">
  </div>


  <p>Até aqui o bot só repete o que você fala, não muito útil. Agora vamos dar a ele a capacidade de entender perguntas e dar respostas específicas. Para isso vamos criar uma função separada chamada <code>responder()</code>, que recebe o que o usuário disse e devolve a resposta certa.</p>

  <p>Por que uma função separada? Porque o chatbot tem duas responsabilidades distintas: <strong>gerenciar a conversa</strong> (loop, encerramento, leitura do input) e <strong>decidir o que responder</strong> (lógica das respostas). Misturar as duas no mesmo bloco deixa o código confuso e difícil de expandir. Separar é uma boa prática que você vai agradecer quando o chatbot crescer.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">009_Exercicio.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">responder</span>(<span class="vr">user</span>):
    <span class="vr">user</span> <span class="op">=</span> <span class="vr">user</span>.<span class="fn">lower</span>()

    <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"oi"</span>:
        <span class="kw">return</span> <span class="st">"Olá! Tudo bem?"</span>

    <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"tudo bem"</span>:
        <span class="kw">return</span> <span class="st">"Estou funcionando perfeitamente 😄"</span>

    <span class="kw">return</span> <span class="st">"Não entendi. Pode reformular?"</span>


<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Digite 'sair' para encerrar.\n"</span>)

    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Encerrando... até logo!"</span>)
            <span class="kw">break</span>

        <span class="vr">resposta</span> <span class="op">=</span> <span class="fn">responder</span>(<span class="vr">user</span>)
        <span class="fn">print</span>(<span class="st">f"Bot: {</span><span class="vr">resposta</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>def responder(user):</td>
      <td><strong>Uma função que recebe o texto do usuário e decide a resposta.</strong> O parâmetro <code>user</code> dentro dos parênteses é o valor que passamos ao chamar a função, como um ingrediente que você entrega para a receita processar.</td>
    </tr>
    <tr>
      <td>return "texto"</td>
      <td><strong>Devolve um valor para quem chamou a função.</strong> Diferente do <code>print()</code>, que só mostra na tela, o <code>return</code> entrega o resultado de volta, nesse caso, a frase de resposta que o chatbot vai imprimir.</td>
    </tr>
    <tr>
      <td>return "Não entendi."</td>
      <td><strong>O fallback, a resposta padrão</strong> quando nenhuma condição anterior foi verdadeira. Todo chatbot precisa de um fallback, senão ele simplesmente não responde quando não entende algo.</td>
    </tr>
    <tr>
      <td>resposta = responder(user)</td>
      <td><strong>Chama a função e guarda o que ela devolveu.</strong> O valor retornado pelo <code>return</code> dentro de <code>responder()</code> fica armazenado na variável <code>resposta</code>, pronto para ser impresso.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 9</div>
    <img src="img/047.png" alt="Resolução do Exercício 9">
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Se eu disser "Oi" com O maiúsculo, ele não vai entender?</div>
  </div>

  <p>Exatamente! O <code>.lower()</code> dentro de <code>responder()</code> converte antes de comparar, então "Oi", "OI" e "oi" são todos tratados como "oi". Mas repara: a comparação aqui é com <code>==</code>, ou seja, o usuário precisa digitar <em>exatamente</em> "oi", nada mais, nada menos. Se digitar "oi tudo bem", não bate. Isso é uma limitação que vamos resolver já na próxima versão.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Exercício 9</div>
    <img src="img/048.png" alt="Resolução do Exercício 9">
  </div><br>



  <!-- BREAK - meio da aula -->
  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa rápida para o café!</h3>
    <p>Levanta, estica as pernas, beba uma água ou um café. A mente aprende melhor com pausas curtas. Volte com energia!</p>
  </div>

  <p>Voltou? Está pronto para continuar? Ótimo. Agora vamos olhar novamente para aquele código que digitamos no VSCode. <i>Agora é hora de evoluir nosso código!</i>.<p>


  <p>Em vez de exigir que o usuário digite a frase exata, podemos verificar se uma palavra aparece <em>em algum lugar</em> do que ele digitou. Para isso usamos o operador <code>in</code>. Se você escreveu "que horas são agora?", o <code>in</code> consegue identificar que a palavra "hora" está lá, e o bot responde corretamente, mesmo sem a frase ser exata.</p>

  <p>Esse é o mecanismo que praticamente todos os chatbots usaram antes da IA: identificação de palavras-chave. A Eliza, o primeiro chatbot da história criado nos anos 60, funcionava exatamente assim. Simples, mas surpreendentemente eficaz para casos bem definidos.</p>

<i><a href="https://elizaemulator.com/" target="_blank">Um emulador da Eliza, só por curiosidade...</a></i>


  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">010_Exercicio.py</div>
    </div>
    <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime

<span class="kw">def</span> <span class="fn">responder</span>(<span class="vr">user</span>):
    <span class="vr">user</span> <span class="op">=</span> <span class="vr">user</span>.<span class="fn">lower</span>()
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()

    <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"olá"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Olá! Tudo bem? Como posso ajudar?"</span>

    <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="fn">strftime</span>(<span class="st">'%H:%M'</span>)<span class="st">}"</span>

    <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"semana"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="vr">dias</span> <span class="op">=</span> {
            <span class="st">"Monday"</span>: <span class="st">"segunda-feira"</span>, <span class="st">"Tuesday"</span>: <span class="st">"terça-feira"</span>,
            <span class="st">"Wednesday"</span>: <span class="st">"quarta-feira"</span>, <span class="st">"Thursday"</span>: <span class="st">"quinta-feira"</span>,
            <span class="st">"Friday"</span>: <span class="st">"sexta-feira"</span>, <span class="st">"Saturday"</span>: <span class="st">"sábado"</span>,
            <span class="st">"Sunday"</span>: <span class="st">"domingo"</span>
        }
        <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="vr">agora</span>.<span class="fn">strftime</span>(<span class="st">'%A'</span>)]<span class="st">}"</span>

    <span class="kw">if</span> <span class="st">"tudo bem"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Estou funcionando perfeitamente 😄"</span>

    <span class="kw">return</span> <span class="st">"Não entendi. Pode reformular?"</span>


<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Pergunte-me as horas, o dia da semana, ou diga 'sair'.\n"</span>)

    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Encerrando... até logo!"</span>)
            <span class="kw">break</span>

        <span class="vr">resposta</span> <span class="op">=</span> <span class="fn">responder</span>(<span class="vr">user</span>)
        <span class="fn">print</span>(<span class="st">f"Bot: {</span><span class="vr">resposta</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>from datetime import datetime</td>
      <td><strong>Importa a ferramenta de data e hora do Python.</strong> O Python vem com várias bibliotecas prontas, <code>datetime</code> é uma delas. O <code>from ... import ...</code> diz: "do pacote datetime, me traga a classe datetime". Assim podemos usar <code>datetime.now()</code> para pegar o momento atual.</td>
    </tr>
    <tr>
      <td>"hora" in user</td>
      <td><strong>Verifica se a palavra "hora" aparece em qualquer lugar do texto.</strong> Diferente do <code>==</code> que exige igualdade total, o <code>in</code> é uma busca, "que horas são?", "me diz a hora" e "hora certa" todos passariam nessa verificação.</td>
    </tr>
    <tr>
      <td>or</td>
      <td><strong>Combina duas condições.</strong> Se qualquer uma delas for verdadeira, o bloco executa. <code>"oi" in user or "olá" in user</code> captura as duas formas de saudação com uma só linha.</td>
    </tr>
    <tr>
      <td>agora.strftime('%H:%M')</td>
      <td><strong>Formata a hora atual.</strong> <code>%H</code> é a hora em formato 24h e <code>%M</code> são os minutos. O <code>strftime</code> (string format time) converte o objeto de data em texto com o formato que você definir.</td>
    </tr>
    <tr>
      <td>dias = { "Monday": "segunda"... }</td>
      <td><strong>Um dicionário de tradução.</strong> O Python retorna o dia da semana em inglês, esse dicionário serve de "tabela de conversão" para português. Você acessa o valor com <code>dias["Monday"]</code> e recebe "segunda-feira".</td>
    </tr>
  </table>

 <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 10</div>
    <img src="img/049.png" alt="Resolução do Exercício 10">
  </div>

  <div class="dica">
    A ordem dos <code>if</code>s dentro de <code>responder()</code> importa. O Python verifica de cima para baixo e executa o primeiro que for verdadeiro. Coloque as condições mais específicas primeiro, se "hora" e "dia" estiverem juntos numa mesma mensagem, qual deve responder? Depende de qual vier antes no código.
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Exercício 10</div>
    <img src="img/050.png" alt="Teste do Exercício 10">
  </div>


  <!-- BREAK -->
  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa rápida!</h3>
    <p>Você acaba de construir um chatbot funcional do zero. Levanta, respira, depois a gente coloca em prática.</p>
  </div>

  <p>Voltou? Agora é a sua vez. Programação se aprende fazendo, não tem atalho. Os três exercícios abaixo aumentam em dificuldade, mas todos usam exatamente o que vimos até aqui. Se der erro, ótimo, faz parte. Lê o erro, entende o que ele está dizendo, e tenta de novo.</p>


  <!-- EXERCÍCIO 11 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 11 -> primeiros passos</span>
    <h3>Crie seu próprio chatbot com condição de saída <span class="ex-diff diff-1">iniciante</span></h3>
    <ol>
      <li>Crie uma função <code>chatbot()</code> com um <code>while True</code></li>
      <li>Leia o input do usuário</li>
      <li>Se o usuário digitar "sair" (em qualquer combinação de maiúsculas/minúsculas), encerre com uma mensagem de despedida</li>
      <li>Caso contrário, repita o que o usuário disse</li>
      <li>Mostre uma mensagem de boas-vindas antes do loop começar</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// uma possível solução</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">011_Exercicio.py</div>
          </div>
          <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Estou aqui para conversar. Digite 'sair' para encerrar.\n"</span>)

    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Foi um prazer conversar! Até logo 👋"</span>)
            <span class="kw">break</span>

        <span class="fn">print</span>(<span class="st">f"Bot: Você disse: {</span><span class="vr">user</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 12 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 12 -> respostas inteligentes</span>
    <h3>Adicione uma função <code>responder()</code> com pelo menos 4 respostas <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Crie uma função <code>responder(user)</code> separada da função <code>chatbot()</code></li>
      <li>Dentro dela, use <code>.lower()</code> para padronizar o input</li>
      <li>Reconheça pelo menos 4 palavras-chave diferentes usando <code>in</code>,por exemplo: "oi", "nome", "ajuda", "tudo bem"</li>
      <li>Sempre tenha um fallback no final: uma resposta para quando nenhuma palavra-chave for encontrada</li>
      <li>Na função <code>chatbot()</code>, chame <code>responder(user)</code> e imprima o resultado</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// uma possível solução</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">012_Exercicio.py</div>
          </div>
          <pre><span class="kw">def</span> <span class="fn">responder</span>(<span class="vr">user</span>):
    <span class="vr">user</span> <span class="op">=</span> <span class="vr">user</span>.<span class="fn">lower</span>()

    <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"olá"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Olá! Como posso ajudar? 😊"</span>

    <span class="kw">if</span> <span class="st">"nome"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Me chamam de Bot. Ainda não tenho um nome oficial!"</span>

    <span class="kw">if</span> <span class="st">"tudo bem"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"tudo bom"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Estou funcionando perfeitamente, obrigado! 😄"</span>

    <span class="kw">if</span> <span class="st">"ajuda"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"help"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Posso responder perguntas sobre meu nome e como estou. Tente!"</span>

    <span class="kw">return</span> <span class="st">"Hmm, não entendi. Pode reformular?"</span>


<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Estou aqui. Digite 'sair' para encerrar.\n"</span>)

    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Até logo! 👋"</span>)
            <span class="kw">break</span>

        <span class="vr">resposta</span> <span class="op">=</span> <span class="fn">responder</span>(<span class="vr">user</span>)
        <span class="fn">print</span>(<span class="st">f"Bot: {</span><span class="vr">resposta</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 13 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 13 -> chatbot com data e hora</span>
    <h3>Adicione respostas dinâmicas com data e hora reais <span class="ex-diff diff-3">avançado</span></h3>
    <ol>
      <li>Importe <code>datetime</code> do módulo <code>datetime</code></li>
      <li>Na função <code>responder()</code>, adicione respostas para: hora atual, dia da semana e mês atual</li>
      <li>Use <code>datetime.now()</code> e <code>.strftime()</code> para formatar as respostas</li>
      <li>Use um dicionário para traduzir o dia da semana do inglês para o português</li>
      <li>Mantenha o fallback e o <code>if __name__</code> no lugar certo</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// uma possível solução</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">013_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime

<span class="kw">def</span> <span class="fn">responder</span>(<span class="vr">user</span>):
    <span class="vr">user</span> <span class="op">=</span> <span class="vr">user</span>.<span class="fn">lower</span>()
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()

    <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"olá"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Olá! Posso te dizer as horas, o dia da semana ou o mês. Pergunte!"</span>

    <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="fn">strftime</span>(<span class="st">'%H:%M'</span>)<span class="st">}"</span>

    <span class="kw">if</span> <span class="st">"semana"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="vr">dias</span> <span class="op">=</span> {
            <span class="st">"Monday"</span>: <span class="st">"segunda-feira"</span>, <span class="st">"Tuesday"</span>: <span class="st">"terça-feira"</span>,
            <span class="st">"Wednesday"</span>: <span class="st">"quarta-feira"</span>, <span class="st">"Thursday"</span>: <span class="st">"quinta-feira"</span>,
            <span class="st">"Friday"</span>: <span class="st">"sexta-feira"</span>, <span class="st">"Saturday"</span>: <span class="st">"sábado"</span>,
            <span class="st">"Sunday"</span>: <span class="st">"domingo"</span>
        }
        <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="vr">agora</span>.<span class="fn">strftime</span>(<span class="st">'%A'</span>)]<span class="st">}"</span>

    <span class="kw">if</span> <span class="st">"mês"</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">or</span> <span class="st">"mes"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="vr">meses</span> <span class="op">=</span> {
            <span class="st">"January"</span>: <span class="st">"janeiro"</span>, <span class="st">"February"</span>: <span class="st">"fevereiro"</span>, <span class="st">"March"</span>: <span class="st">"março"</span>,
            <span class="st">"April"</span>: <span class="st">"abril"</span>, <span class="st">"May"</span>: <span class="st">"maio"</span>, <span class="st">"June"</span>: <span class="st">"junho"</span>,
            <span class="st">"July"</span>: <span class="st">"julho"</span>, <span class="st">"August"</span>: <span class="st">"agosto"</span>, <span class="st">"September"</span>: <span class="st">"setembro"</span>,
            <span class="st">"October"</span>: <span class="st">"outubro"</span>, <span class="st">"November"</span>: <span class="st">"novembro"</span>, <span class="st">"December"</span>: <span class="st">"dezembro"</span>
        }
        <span class="kw">return</span> <span class="st">f"Estamos em {</span><span class="vr">meses</span>[<span class="vr">agora</span>.<span class="fn">strftime</span>(<span class="st">'%B'</span>)]<span class="st">}"</span>

    <span class="kw">if</span> <span class="st">"tudo bem"</span> <span class="kw">in</span> <span class="vr">user</span>:
        <span class="kw">return</span> <span class="st">"Estou funcionando perfeitamente 😄"</span>

    <span class="kw">return</span> <span class="st">"Não entendi. Tente perguntar sobre horas, dia ou mês!"</span>


<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Bot: Olá! Pergunte-me as horas, o dia ou o mês. Digite 'sair' para encerrar.\n"</span>)

    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)

        <span class="kw">if</span> <span class="vr">user</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Até logo! Foi um prazer 👋"</span>)
            <span class="kw">break</span>

        <span class="vr">resposta</span> <span class="op">=</span> <span class="fn">responder</span>(<span class="vr">user</span>)
        <span class="fn">print</span>(<span class="st">f"Bot: {</span><span class="vr">resposta</span><span class="st">}"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">

      <a class="dl-item" href="arquivos/006_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">006_Exercício.py</div>
          <div class="dl-desc">Chatbot completo com hora, dia da semana, mês e memória de nome</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/007_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">007_Exercício.py</div>
          <div class="dl-desc">Versão comentada linha a linha, ideal para estudar</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/008_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">008_Exercício.py</div>
          <div class="dl-desc">Melhora a experiência — .lower(), mensagens de boas-vindas e if __name__</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/009_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">009_Exercício.py</div>
          <div class="dl-desc">Separa responsabilidades — função responder() com return e fallback</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>


      <a class="dl-item" href="arquivos/010_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">010_Exercício.py</div>
          <div class="dl-desc">Reconhece palavras-chave — operador in, datetime, hora e dia da semana</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/011_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">011_Exercício.py</div>
          <div class="dl-desc">Exercício 1 — chatbot com saída, boas-vindas e repetição de input</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/012_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">012_Exercício.py</div>
          <div class="dl-desc">Exercício 2 — função responder() com 4 palavras-chave e fallback</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>


      <a class="dl-item" href="arquivos/013_Exercício.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">013_Exercício.py</div>
          <div class="dl-desc">Exercício 3 — chatbot com hora, dia da semana e mês em português</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>


    </div>
  </div>

  <div class="ready">
    <span class="re">🎉</span>
    <h2>Pronto para a Aula 2!</h2>
    <p>Bora seguir aprendendo? Nos vemos lá!</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="nivelamento.php">← Nivelamento</a>
    <a class="nav-link next" href="aula2.php">Aula 2 →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>



<footer>
  <span>Chatbots com Python · aula 1</span>
  <span><a href="AulaChatbot.html">← índice</a></span>
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
