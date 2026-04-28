<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aula 2 - Chatbots com Python</title>
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
.er{color:#a83030; text-decoration: underline wavy #a83030;}

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
.code-ann tr.bug td:first-child { color:var(--red); background:var(--red-lt); }

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
    <span class="tb-lesson">aula 02 · correção e escala</span>
    <a class="tb-btn" href="aula1.php">←</a>
    <a class="tb-btn next" href="aula3.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">aula 02</span>
    <h1>Corrigir é tão<br>importante quanto <em>criar</em></h1>
    <p>Na aula anterior você criou um chatbot do zero. Hoje a gente vai trabalhar diferente: vamos pegar código quebrado, identificar o que está errado e consertá-lo. Isso pode parecer menos glamouroso do que criar, mas na prática de desenvolvimento real, a maior parte do tempo é gasto corrigindo e melhorando código que já existe, não escrevendo do zero.</p>
  </div>

  <p>Antes de ver o código, pensa no seguinte: quanto maior fica um programa, cheio de <code>if</code>s, mais difícil fica mantê-lo. Se você tem 30 condições empilhadas e precisa corrigir uma, corre o risco de quebrar outra. Se precisa adicionar uma nova resposta, precisa lembrar da ordem certa para não criar conflito. Código assim funciona, até o dia que para de funcionar, e ninguém sabe onde mexer.</p>

  <p>Esse é exatamente o problema do código abaixo. Ele tem erros, alguns que travam o programa na hora de rodar, e outros que só aparecem quando o usuário digita algo inesperado. Veja se consegue achar todos antes de ler a explicação:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">014_Exercicio.py -> encontre os erros</div>
    </div>
    <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="vr">hoje</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="vr">hoje</span>.<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="vr">respostas</span> <span class="op">=</span> []

        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="st">"Olá!"</span>)
        <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="er">get_hora</span>)    <span class="cm"># ← erro 1</span>
        <span class="kw">if</span> <span class="st">"data"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_data</span>())
        <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_dia_semana</span>())
        <span class="kw">if</span> <span class="st">"sair"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Encerrando..."</span>)          <span class="cm"># ← erro 2: falta o break</span>

        <span class="kw">if</span> <span class="vr">respostas</span> <span class="op">==</span> <span class="nm">0</span>:              <span class="cm"># ← erro 3</span>
            <span class="fn">print</span>(<span class="st">"Não entendi..."</span>)
        <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)

<span class="fn">chatbot</span>()</pre>
  </div>

  <p>Três erros, três tipos diferentes de problema. Vamos destrinchar cada um:</p>

  <table class="code-ann">
    <tr class="bug">
      <td>respostas.append(get_hora)</td>
      <td><strong>Erro de lógica, a função foi adicionada, não chamada.</strong> Sem os parênteses, o Python não executa <code>get_hora</code>, ele guarda o endereço da função na lista, não o resultado dela. Quando o bot tentar imprimir, vai aparecer algo como <code>&lt;function get_hora at 0x...&gt;</code> em vez da hora. O correto é <code>get_hora()</code>, com parênteses, para de fato chamar e receber o retorno.</td>
    </tr>
    <tr class="bug">
      <td>if "sair" in user: print(...)</td>
      <td><strong>Erro de lógica, falta o <code>break</code>.</strong> O chatbot imprime "Encerrando..." mas continua rodando. O loop nunca para porque a instrução de encerramento (<code>break</code>) foi esquecida. O usuário vê a mensagem mas não sai, o bot simplesmente pede o próximo input.</td>
    </tr>
    <tr class="bug">
      <td>if respostas == 0</td>
      <td><strong>Erro de execução, comparação de tipos incompatíveis.</strong> <code>respostas</code> é uma lista, e uma lista nunca vai ser igual ao número <code>0</code>. A comparação correta para verificar se a lista está vazia é <code>if not respostas</code>, que em Python significa "se a lista estiver vazia".</td>
    </tr>
  </table>

  <div class="dica">
    Existem dois tipos de erro em programação: <strong>erro de execução</strong>, o programa trava e o Python aponta a linha exata, e <strong>erro de lógica</strong>, o programa roda normalmente, mas faz a coisa errada. O segundo é muito mais difícil de encontrar, porque não aparece em vermelho. A única forma de pegar é testando com cenários diferentes do que você planejou.
  </div>

  <p>Agora veja o mesmo código corrigido. Repare nas três mudanças e execute para confirmar que funciona:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">014_Exercicio.py - versão corrigida</div>
    </div>
    <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="vr">hoje</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="vr">hoje</span>.<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="vr">respostas</span> <span class="op">=</span> []

        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="st">"Olá!"</span>)
        <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_hora</span>())   <span class="cm"># ✓ com parênteses</span>
        <span class="kw">if</span> <span class="st">"data"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_data</span>())
        <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_dia_semana</span>())
        <span class="kw">if</span> <span class="st">"sair"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Encerrando..."</span>)
            <span class="kw">break</span>                          <span class="cm"># ✓ break adicionado</span>

        <span class="kw">if not</span> <span class="vr">respostas</span>:                 <span class="cm"># ✓ verificação correta de lista vazia</span>
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)

<span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>respostas = []</td>
      <td><strong>Uma lista vazia criada a cada iteração do loop.</strong> Cada vez que o usuário manda uma mensagem, a lista é zerada, assim as respostas de uma pergunta não "vazam" para a próxima. A lista vai recebendo respostas com <code>.append()</code> conforme as condições baterem.</td>
    </tr>
    <tr>
      <td>.append(get_hora())</td>
      <td><strong>Adiciona o resultado da função à lista.</strong> O <code>.append()</code> insere um item no final de uma lista. Aqui, chamamos <code>get_hora()</code> com parênteses para executá-la e guardar o texto que ela retorna, não a função em si.</td>
    </tr>
    <tr>
      <td>if not respostas:</td>
      <td><strong>Verifica se a lista está vazia.</strong> Em Python, uma lista vazia é considerada "falsa", então <code>if not respostas</code> significa "se a lista não tiver nada". É a forma correta e idiomática de fazer essa verificação.</td>
    </tr>
    <tr>
      <td>for r in respostas:</td>
      <td><strong>Percorre cada item da lista e imprime.</strong> O loop <code>for</code> pega um item por vez, aqui chamado de <code>r</code>, e executa o bloco indentado para cada um. Se o usuário perguntou hora e dia ao mesmo tempo, ambas as respostas são impressas, uma por linha.</td>
    </tr>
  </table>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Por que usar uma lista de respostas em vez de só um if/elif como antes?</div>
  </div>

  <p>Boa pergunta. Com <code>elif</code>, só uma condição executa, a primeira que for verdadeira. Se o usuário digitar "que horas são hoje?", você quer que o bot responda tanto a hora quanto a data. Com a lista, todas as condições são verificadas independentemente e todas as respostas que baterem são entregues juntas. Além de ser mais flexível, economiza, ao invés de o usuário fazer duas perguntas separadas, o bot resolve tudo numa só troca.</p>

  <p>O código está corrigido e funcionando bem. Mas ainda tem um problema silencioso: ele não lida com acentos. Se o usuário digitar "horário" com acento, a palavra "hora" está lá, o <code>in</code> vai encontrar. Mas e se digitar "Boa tarde" em vez de "oi"? Ou "semana que vem"? E se o usuário escrever com letras maiúsculas ou errar uma acentuação? O <code>.lower()</code> resolve maiúsculas, mas não resolve acentos. "dia" e "día" são strings diferentes para o Python.</p>

  <p>A solução é <strong>normalizar</strong> o input antes de processar, transformar o texto removendo acentos, cedilhas e outros caracteres especiais. O Python tem uma biblioteca pronta para isso chamada <code>unicodedata</code>:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">015_Exercicio.py — tratando acentos</div>
    </div>
    <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime
<span class="kw">import</span> unicodedata

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="fn">datetime</span>.<span class="fn">now</span>().<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="fn">input</span>(<span class="st">"Você: "</span>))

        <span class="vr">respostas</span> <span class="op">=</span> []
        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="st">"Olá!"</span>)
        <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_hora</span>())
        <span class="kw">if</span> <span class="st">"data"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_data</span>())
        <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_dia_semana</span>())
        <span class="kw">if</span> <span class="st">"sair"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Encerrando..."</span>)
            <span class="kw">break</span>

        <span class="kw">if not</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)

<span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>import unicodedata</td>
      <td><strong>Importa a biblioteca de dados Unicode do Python.</strong> Unicode é o padrão que define como os caracteres são representados, incluindo letras acentuadas. Essa biblioteca já vem com o Python, não precisa instalar nada.</td>
    </tr>
    <tr>
      <td>def normalizar(texto):</td>
      <td><strong>Uma função que limpa o texto antes de processar.</strong> Ela faz dois passos: primeiro converte para minúsculas com <code>.lower()</code>, depois remove os acentos. O resultado é um texto padronizado onde "Horário", "horario" e "HORÁRIO" viram todos "horario".</td>
    </tr>
    <tr>
      <td>unicodedata.category(c) != "Mn"</td>
      <td><strong>Filtra os caracteres que são marcas diacríticas</strong>, o nome técnico para acentos e cedilhas. A categoria <code>"Mn"</code> significa "marca não espaçante" (Non-spacing Mark). O código percorre cada letra do texto e descarta as que forem dessa categoria, mantendo só os caracteres base.</td>
    </tr>
    <tr>
      <td>user = normalizar(input(...))</td>
      <td><strong>Normaliza o input antes de qualquer comparação.</strong> Agora tudo que o usuário digitar, com ou sem acento, maiúsculo ou minúsculo, passa pela limpeza antes de chegar nos <code>if</code>s. As palavras-chave nas comparações também não precisam mais ter versão com acento.</td>
    </tr>
  </table>

  <p>O código está bem melhor. Mas ainda tem aquele problema estrutural: conforme o chatbot cresce, os <code>if</code>s se acumulam. Adicionar uma nova intenção significa lembrar de colocar o <code>if</code> no lugar certo, na ordem certa, sem conflitar com os outros. Existe uma forma mais organizada de fazer isso, e é o que vamos ver agora.</p>

  <p>Em vez de uma sequência de <code>if</code>s, podemos guardar todas as intenções do chatbot em um <strong>dicionário</strong>. Cada intenção tem um nome, uma lista de palavras-chave que a disparam, e a função que executa quando ela é detectada. Para adicionar uma nova capacidade ao bot, basta incluir uma entrada no dicionário, sem tocar no resto do código:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">016_Exercicio.py — dicionário de intenções</div>
    </div>
    <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime
<span class="kw">import</span> unicodedata

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="fn">datetime</span>.<span class="fn">now</span>().<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">sair</span>():
    <span class="kw">return</span> <span class="st">"Encerrando..."</span>

<span class="bi">INTENTS</span> <span class="op">=</span> {
    <span class="st">"saudacao"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"oi"</span>, <span class="st">"ola"</span>, <span class="st">"eae"</span>],
        <span class="st">"action"</span>: <span class="kw">lambda</span>: <span class="st">"Olá! Como posso ajudar?"</span>
    },
    <span class="st">"hora"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"hora"</span>, <span class="st">"horas"</span>],
        <span class="st">"action"</span>: <span class="fn">get_hora</span>
    },
    <span class="st">"data"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"data"</span>, <span class="st">"hoje"</span>],
        <span class="st">"action"</span>: <span class="fn">get_data</span>
    },
    <span class="st">"dia_semana"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"dia"</span>, <span class="st">"semana"</span>],
        <span class="st">"action"</span>: <span class="fn">get_dia_semana</span>
    },
    <span class="st">"sair"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"sair"</span>, <span class="st">"tchau"</span>, <span class="st">"ate mais"</span>],
        <span class="st">"action"</span>: <span class="fn">sair</span>
    }
}

<span class="kw">def</span> <span class="fn">detectar_intencoes</span>(<span class="vr">user</span>):
    <span class="vr">respostas</span> <span class="op">=</span> []
    <span class="vr">encerrar</span> <span class="op">=</span> <span class="kw">False</span>
    <span class="kw">for</span> <span class="vr">intent</span> <span class="kw">in</span> <span class="bi">INTENTS</span>.<span class="fn">values</span>():
        <span class="kw">if</span> <span class="fn">any</span>(<span class="vr">kw</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">for</span> <span class="vr">kw</span> <span class="kw">in</span> <span class="vr">intent</span>[<span class="st">"keywords"</span>]):
            <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">intent</span>[<span class="st">"action"</span>]()
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="vr">resposta</span>)
            <span class="kw">if</span> <span class="vr">intent</span>[<span class="st">"action"</span>] <span class="op">==</span> <span class="fn">sair</span>:
                <span class="vr">encerrar</span> <span class="op">=</span> <span class="kw">True</span>
    <span class="kw">return</span> <span class="vr">respostas</span>, <span class="vr">encerrar</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="fn">input</span>(<span class="st">"Você: "</span>))
        <span class="vr">respostas</span>, <span class="vr">encerrar</span> <span class="op">=</span> <span class="fn">detectar_intencoes</span>(<span class="vr">user</span>)
        <span class="kw">if not</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)
        <span class="kw">if</span> <span class="vr">encerrar</span>:
            <span class="kw">break</span>

<span class="fn">chatbot</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>INTENTS = { ... }</td>
      <td><strong>Um dicionário que centraliza todas as intenções do chatbot.</strong> Cada chave é o nome da intenção (<code>"hora"</code>, <code>"saudacao"</code>...), e o valor é outro dicionário com duas entradas: <code>"keywords"</code>, a lista de palavras que disparam essa intenção, e <code>"action"</code>, a função a executar. Em maiúsculas por convenção: variáveis escritas assim indicam que o valor não muda durante a execução.</td>
    </tr>
    <tr>
      <td>lambda: "Olá!"</td>
      <td><strong>Uma função anônima de uma linha.</strong> <code>lambda</code> cria uma função sem precisar do <code>def</code>. Aqui usamos porque a saudação é só um texto fixo, não vale criar uma função inteira para isso. É como um atalho: <code>lambda: "Olá!"</code> é equivalente a <code>def f(): return "Olá!"</code>.</td>
    </tr>
    <tr>
      <td>any(kw in user for kw in intent["keywords"])</td>
      <td><strong>Verifica se alguma palavra-chave aparece no input.</strong> O <code>any()</code> retorna <code>True</code> se pelo menos uma condição da sequência for verdadeira. A expressão percorre todas as keywords da intenção e retorna <code>True</code> assim que encontrar a primeira que bater no texto do usuário.</td>
    </tr>
    <tr>
      <td>respostas, encerrar = detectar_intencoes(user)</td>
      <td><strong>Uma função que retorna dois valores ao mesmo tempo.</strong> Em Python, uma função pode devolver múltiplos valores separados por vírgula, e você pode recebê-los em variáveis separadas na mesma linha. Aqui recebemos a lista de respostas e um sinalizador indicando se o bot deve encerrar.</td>
    </tr>
    <tr>
      <td>encerrar = True / if encerrar: break</td>
      <td><strong>Uma variável que sinaliza quando parar o loop.</strong> Em vez de chamar <code>break</code> diretamente dentro de <code>detectar_intencoes()</code>, o que seria impossível, pois o loop está em outro lugar, a função "avisa" o chatbot através dessa variável. O <code>break</code> só é executado depois que todas as respostas já foram impressas.</td>
    </tr>
  </table>

  <div class="dica">
    Para adicionar uma nova capacidade ao chatbot agora, basta incluir uma entrada no dicionário <code>INTENTS</code>. Crie a função, defina as palavras-chave e pronto, sem tocar em nenhuma outra parte do código. Isso é o que se chama de <strong>código escalável</strong>: cresce sem quebrar o que já existe.
  </div>


  <!-- BREAK -->
  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa rápida para o café!</h3>
    <p>Vamos seguir nessa animação! Nos vemos lá!</p>
  </div>

  <p>Antes de praticar, vale falar de algo que todo desenvolvedor aprende na prática: existe uma diferença importante entre <strong>erros de execução</strong> e <strong>erros de lógica</strong>.</p>

  <p>Erros de execução são os mais fáceis de resolver, porque o Python grita. Ele para tudo, aponta a linha e diz o que aconteceu. Você viu isso com o código quebrado que analisamos: falta de parênteses, função não chamada corretamente, o terminal deixou bem claro onde estava o problema.</p>

  <p>Erros de lógica são mais traiçoeiros. O programa roda sem nenhuma mensagem de erro. Ele simplesmente faz a coisa errada em silêncio. O chatbot responde quando não deveria, ou deixa de responder quando deveria. Nada quebra, mas o comportamento está errado. Esse tipo de problema é muito mais difícil de identificar porque você precisa testar vários caminhos para perceber que algo não está certo.</p>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Como eu sei quais caminhos testar? Nunca vou conseguir testar tudo...</div>
  </div>

  <p>Exatamente por isso que pedir para outra pessoa testar faz tanta diferença. Quando você escreveu o código, você sabe o que ele deveria fazer, e sem querer você vai testar só os caminhos que você pensou. Quem não escreveu o código vai testar do jeito que achar natural, digitando coisas que você nunca imaginou. Vai tentar sair sem digitar "sair", vai testar palavras com acento diferente, vai misturar maiúsculas e minúsculas do jeito mais inesperado. Esse olhar externo é o que revela os erros de lógica que o desenvolvedor não vê.</p>




  <p>Agora é a sua vez. Os exercícios abaixo partem do que você acabou de ver. O primeiro é direto, apenas identificar e corrigir. O segundo pede que você expanda. O terceiro é o desafio: criar um chatbot do zero com tudo que aprendemos nas duas aulas.</p>

  <!-- EXERCÍCIO 1 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 17 -> encontre e corrija</span>
    <h3>O código abaixo tem erros. Encontre e corrija todos. <span class="ex-diff diff-1">iniciante</span></h3>
    <ol>
      <li>Copie o <code>014_Exercicio.py</code> e corrija diretamente nele</li>
      <li>Execute e observe o que acontece</li>
      <li>Corrija os três erros discutidos na aula</li>
      <li>Execute novamente e teste: hora, data, dia, sair, tudo deve funcionar</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// solução — o 014_Exercicio.py corrigido</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">014_Exercicio.py - corrigido</div>
          </div>
          <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="vr">hoje</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="vr">hoje</span>.<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="vr">respostas</span> <span class="op">=</span> []
        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="st">"Olá!"</span>)
        <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_hora</span>())
        <span class="kw">if</span> <span class="st">"data"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_data</span>())
        <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_dia_semana</span>())
        <span class="kw">if</span> <span class="st">"sair"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Encerrando..."</span>)
            <span class="kw">break</span>
        <span class="kw">if not</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)

<span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 2 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 18 -> adicione normalização</span>
    <h3>Adicione tratamento de acentos ao código corrigido <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Copie o <code>014_Exercicio.py</code> corrigido para <code>015_Exercicio.py</code></li>
      <li>Importe <code>unicodedata</code> no topo do arquivo</li>
      <li>Crie a função <code>normalizar(texto)</code> que remove acentos e converte para minúsculas</li>
      <li>Substitua <code>input(...).lower()</code> por <code>normalizar(input(...))</code></li>
      <li>Teste digitando "Horário", "HORA", "Sáir". o bot deve reconhecer tudo</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// a solução é o próprio 015_Exercicio.py</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">015_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime
<span class="kw">import</span> unicodedata

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="fn">datetime</span>.<span class="fn">now</span>().<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="fn">input</span>(<span class="st">"Você: "</span>))
        <span class="vr">respostas</span> <span class="op">=</span> []
        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="st">"Olá!"</span>)
        <span class="kw">if</span> <span class="st">"hora"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_hora</span>())
        <span class="kw">if</span> <span class="st">"data"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_data</span>())
        <span class="kw">if</span> <span class="st">"dia"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="fn">get_dia_semana</span>())
        <span class="kw">if</span> <span class="st">"sair"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Encerrando..."</span>)
            <span class="kw">break</span>
        <span class="kw">if not</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)

<span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 3 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 19 -> seu chatbot com INTENTS</span>
    <h3>Crie um chatbot para um tema à sua escolha usando dicionário de intenções <span class="ex-diff diff-3">avançado</span></h3>
    <ol>
      <li>Escolha um tema: suporte técnico, lanchonete, clínica, assistente pessoal, qualquer um</li>
      <li>Crie pelo menos 4 intenções no dicionário <code>INTENTS</code>, cada uma com suas palavras-chave e função</li>
      <li>Use <code>normalizar()</code> no input</li>
      <li>Use <code>detectar_intencoes()</code> para processar as respostas</li>
      <li>Inclua uma intenção de encerramento com <code>break</code> via flag <code>encerrar</code></li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// a solução é o próprio 016_Exercicio.py</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">016_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> datetime <span class="kw">import</span> datetime
<span class="kw">import</span> unicodedata

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="kw">def</span> <span class="fn">get_hora</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Agora são {</span><span class="vr">agora</span>.<span class="vr">hour</span><span class="st">}:{</span><span class="vr">agora</span>.<span class="vr">minute</span><span class="st">:02d}"</span>

<span class="kw">def</span> <span class="fn">get_data</span>():
    <span class="vr">agora</span> <span class="op">=</span> <span class="fn">datetime</span>.<span class="fn">now</span>()
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">agora</span>.<span class="vr">day</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">month</span><span class="st">}/{</span><span class="vr">agora</span>.<span class="vr">year</span><span class="st">}"</span>

<span class="kw">def</span> <span class="fn">get_dia_semana</span>():
    <span class="vr">dias</span> <span class="op">=</span> [<span class="st">"Segunda"</span>, <span class="st">"Terça"</span>, <span class="st">"Quarta"</span>, <span class="st">"Quinta"</span>, <span class="st">"Sexta"</span>, <span class="st">"Sábado"</span>, <span class="st">"Domingo"</span>]
    <span class="kw">return</span> <span class="st">f"Hoje é {</span><span class="vr">dias</span>[<span class="fn">datetime</span>.<span class="fn">now</span>().<span class="fn">weekday</span>()]<span class="st">}"</span>

<span class="kw">def</span> <span class="fn">sair</span>():
    <span class="kw">return</span> <span class="st">"Encerrando..."</span>

<span class="bi">INTENTS</span> <span class="op">=</span> {
    <span class="st">"saudacao"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"oi"</span>, <span class="st">"ola"</span>, <span class="st">"eae"</span>],
        <span class="st">"action"</span>: <span class="kw">lambda</span>: <span class="st">"Olá! Como posso ajudar?"</span>
    },
    <span class="st">"hora"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"hora"</span>, <span class="st">"horas"</span>],
        <span class="st">"action"</span>: <span class="fn">get_hora</span>
    },
    <span class="st">"data"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"data"</span>, <span class="st">"hoje"</span>],
        <span class="st">"action"</span>: <span class="fn">get_data</span>
    },
    <span class="st">"dia_semana"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"dia"</span>, <span class="st">"semana"</span>],
        <span class="st">"action"</span>: <span class="fn">get_dia_semana</span>
    },
    <span class="st">"sair"</span>: {
        <span class="st">"keywords"</span>: [<span class="st">"sair"</span>, <span class="st">"tchau"</span>, <span class="st">"ate mais"</span>],
        <span class="st">"action"</span>: <span class="fn">sair</span>
    }
}

<span class="kw">def</span> <span class="fn">detectar_intencoes</span>(<span class="vr">user</span>):
    <span class="vr">respostas</span> <span class="op">=</span> []
    <span class="vr">encerrar</span> <span class="op">=</span> <span class="kw">False</span>
    <span class="kw">for</span> <span class="vr">intent</span> <span class="kw">in</span> <span class="bi">INTENTS</span>.<span class="fn">values</span>():
        <span class="kw">if</span> <span class="fn">any</span>(<span class="vr">kw</span> <span class="kw">in</span> <span class="vr">user</span> <span class="kw">for</span> <span class="vr">kw</span> <span class="kw">in</span> <span class="vr">intent</span>[<span class="st">"keywords"</span>]):
            <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">intent</span>[<span class="st">"action"</span>]()
            <span class="vr">respostas</span>.<span class="fn">append</span>(<span class="vr">resposta</span>)
            <span class="kw">if</span> <span class="vr">intent</span>[<span class="st">"action"</span>] <span class="op">==</span> <span class="fn">sair</span>:
                <span class="vr">encerrar</span> <span class="op">=</span> <span class="kw">True</span>
    <span class="kw">return</span> <span class="vr">respostas</span>, <span class="vr">encerrar</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado..."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="fn">input</span>(<span class="st">"Você: "</span>))
        <span class="vr">respostas</span>, <span class="vr">encerrar</span> <span class="op">=</span> <span class="fn">detectar_intencoes</span>(<span class="vr">user</span>)
        <span class="kw">if not</span> <span class="vr">respostas</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi..."</span>)
        <span class="kw">else</span>:
            <span class="kw">for</span> <span class="vr">r</span> <span class="kw">in</span> <span class="vr">respostas</span>:
                <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">r</span>)
        <span class="kw">if</span> <span class="vr">encerrar</span>:
            <span class="kw">break</span>

<span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

 

  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">

      <a class="dl-item" href="arquivos/014_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">014_Exercicio.py</div>
          <div class="dl-desc">Código com erros — encontre e corrija os três problemas</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/015_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">015_Exercicio.py</div>
          <div class="dl-desc">Adiciona normalizar() com unicodedata para tratar acentos</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/016_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">016_Exercicio.py</div>
          <div class="dl-desc">Versão final com dicionário INTENTS e detectar_intencoes()</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/017_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">017_Exercicio.py</div>
          <div class="dl-desc">Exercício 17 - código com os três bugs corrigidos</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>


      <a class="dl-item" href="arquivos/018_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">018_Exercicio.py</div>
          <div class="dl-desc">Exercício 18 - normalizar() aplicada ao chatbot corrigido</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>


      <a class="dl-item" href="arquivos/019_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">019_Exercicio.py</div>
          <div class="dl-desc">Exercício 19 - chatbot com INTENTS para tema à sua escolha</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

    </div>
  </div>


  <div class="ready">
    <span class="re">🎉</span>
    <h2>Pronto para a Aula 3!</h2>
    <p>Está animado para as próximas aulas? Eu estou...  Nos vemos lá!</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="aula1.php">← Aula 1</a>
    <a class="nav-link next" href="aula3.php">Aula 3 →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>



<footer>
  <span>Chatbots com Python · aula 2</span>
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
