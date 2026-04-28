<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Revisão - Chatbots com Python</title>
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
.install-step { margin:24px 0; background:var(--surface); border:1px solid var(--border); border-radius:8px; overflow:hidden; box-shadow:var(--shadow-sm); }
.install-step-head { display:flex; align-items:center; gap:10px; padding:10px 16px; background:var(--bg); border-bottom:1px solid var(--border); font-size:.82rem; font-weight:800; color:var(--text2); }
.install-num { width:22px; height:22px; border-radius:50%; background:var(--accent); color:#fff; display:flex; align-items:center; justify-content:center; font-family:'Fira Code',monospace; font-size:11px; flex-shrink:0; }
.install-step img { width:100%; display:block; }
.lousa { background:var(--board); border-radius:6px; padding:14px 18px; margin:22px auto; max-width:480px; box-shadow:var(--shadow-sm); }
.lousa-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; color:#6aaa78; margin-bottom:10px; }
.lousa-row { display:flex; gap:9px; align-items:flex-start; margin-bottom:7px; font-size:.86rem; color:#c8e4cc; line-height:1.6; font-family:'Nunito',sans-serif; }
.lousa-row:last-child { margin-bottom:0; }
.lousa-row .bul { color:#5ad68a; flex-shrink:0; margin-top:2px; }
.lousa strong { color:#e8f5e8; font-weight:700; }
.lousa code { background:rgba(255,255,255,.12); border-color:rgba(255,255,255,.18); color:#a8e8c0; font-size:.8em; }
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
.er{color:#a83030; text-decoration:underline wavy #a83030;}
.code-ann { margin:16px 0 24px; border-collapse:collapse; width:100%; }
.code-ann tr { border-bottom:1px solid var(--border); }
.code-ann tr:last-child { border-bottom:none; }
.code-ann td { padding:8px 10px; font-size:.85rem; vertical-align:top; line-height:1.65; }
.code-ann td:first-child { font-family:'Fira Code',monospace; font-size:.78rem; white-space:nowrap; color:var(--accent); background:var(--accent-lt); border-radius:4px; width:1%; padding:8px 12px; }
.code-ann td:last-child { color:var(--text2); }
.code-ann td strong { color:var(--text); }
.code-ann tr.bug td:first-child { color:var(--red); background:var(--red-lt); }
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
.diff-2 { background:var(--gold-lt); color:var(--gold); }
.diff-3 { background:var(--red-lt); color:var(--red); }
.ex-ans { margin-top:14px; padding-top:14px; border-top:1px solid var(--border); }
.ex-ans-tag { font-family:'Fira Code',monospace; font-size:9.5px; letter-spacing:.15em; color:var(--green); text-transform:uppercase; margin-bottom:8px; display:block; }
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
    <a class="tb-btn" href="../index.html"">⊞ índice</a>
    <span class="tb-lesson">revisão · consolidando o caminho</span>
    <a class="tb-btn" href="aula4.php">←</a>
    <a class="tb-btn next" href="aula5.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">revisão</span>
    <h1>Uma pausa no caminho:<br><em>fechando as pontas</em></h1>
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Professora, toda vez que dá erro no terminal eu fico perdida. Aparece um monte de texto vermelho e não sei nem por onde começar a olhar...</div>
  </div>

  <p>Isso é absolutamente normal e tem solução simples. O terminal parece caótico na primeira vez, mas toda mensagem de erro em Python segue a mesma estrutura: ela diz o arquivo, a linha, o trecho do código e o tipo do problema. Quando nós sabemos o que procurar, a leitura fica rápida.</p>

  <p>Os erros mais comuns têm nomes e comportamentos previsíveis. Cada um deles apareceu, ou vai aparecer, em algum exercício do curso. Nós vemos cada tipo com calma: o código quebrado, o que o terminal mostra, e o que fazer.</p>

  <p>O <strong>SyntaxError</strong> é o mais direto de todos. Acontece quando o Python não consegue sequer ler o código porque falta um caractere essencial: dois-pontos no final de um <code>def</code> ou <code>if</code>, parêntese que não fecha, aspas que não fecha. O Python para na primeira linha que não faz sentido e aponta com um <code>^</code> onde parou de entender.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">codigo_com_erro.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn"><span class="er">get_saudacao()</span></span>
    <span class="vr">mensagem</span> <span class="op">=</span> <span class="st">"Olá! Tudo bem?"</span>
    <span class="kw">return</span> <span class="vr">mensagem</span>

<span class="fn">print</span>(<span class="fn">get_saudacao</span>())</pre>
  </div>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">terminal</div>
    </div>
    <pre><span class="cm">  File "codigo_com_erro.py", line 1</span>
<span class="cm">    def get_saudacao()</span>
<span class="cm">                      ^</span>
<span class="vr">SyntaxError: expected ':'</span></pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>File "...", line 1</td>
      <td><strong>Arquivo e número da linha onde o Python parou.</strong> Sempre o primeiro lugar para olhar. Abra o arquivo, vá para essa linha.</td>
    </tr>
    <tr>
      <td>^</td>
      <td><strong>O cursor aponta onde o Python desistiu de ler.</strong> Aqui ele aponta depois do parêntese de fechamento. É onde falta o dois-pontos.</td>
    </tr>
    <tr class="bug">
      <td>SyntaxError: expected ':'</td>
      <td><strong>O tipo do erro e a descrição.</strong> "expected ':'" significa que o Python esperava um dois-pontos naquela posição. A correção é adicionar <code>:</code> ao final da linha do <code>def</code>.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> SyntaxError</div>
    <img src="img/083.png" alt="SyntaxError">
  </div>




  <p>O <strong>IndentationError</strong> acontece quando a indentação, os espaços no início de uma linha, não está no nível esperado. O Python usa esses espaços para entender o que está dentro de um bloco, como o corpo de um <code>def</code>, de um <code>while</code> ou de um <code>if</code>. Uma linha que deveria estar indentada mas não está quebra a estrutura inteira.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">codigo_com_erro.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>)
        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="er">break</span>
        <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">user</span>)</pre>
  </div>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">terminal</div>
    </div>
    <pre><span class="cm">  File "codigo_com_erro.py", line 5</span>
<span class="cm">    break</span>
<span class="cm">    ^</span>
<span class="vr">IndentationError: expected an indented block after 'if' statement on line 4</span></pre>
  </div>

  <table class="code-ann">
    <tr class="bug">
      <td>expected an indented block after 'if'</td>
      <td><strong>O Python diz exatamente o que espera.</strong> O <code>if</code> na linha 4 abre um bloco, e o <code>break</code> deveria estar dentro dele, com um nível a mais de indentação. A correção é adicionar 4 espaços antes do <code>break</code>.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div>  IndentationError</div>
    <img src="img/084.png" alt=" IndentationError">
  </div>





  <p>O <strong>NameError</strong> aparece quando o código tenta usar um nome de variável ou função que o Python não conhece naquele momento. As causas mais comuns são erro de digitação no nome, usar a variável antes de defini-la, ou esquecer que Python diferencia maiúsculas de minúsculas: <code>Mensagem</code> e <code>mensagem</code> são nomes diferentes.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">codigo_com_erro.py</div>
    </div>
    <pre><span class="vr">nome</span> <span class="op">=</span> <span class="st">"Assistente"</span>
<span class="vr">mensagem</span> <span class="op">=</span> <span class="st">"Olá! Sou o "</span> <span class="op">+</span> <span class="vr">nome</span> <span class="op">+</span> <span class="st">"."</span>
<span class="fn">print</span>(<span class="vr">mensagem</span>)
<span class="fn">print</span>(<span class="st">"Versão:"</span>, <span class="er">versao</span>)</pre>
  </div>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">terminal</div>
    </div>
    <pre><span class="cm">Traceback (most recent call last):</span>
<span class="cm">  File "codigo_com_erro.py", line 4, in &lt;module&gt;</span>
<span class="cm">    print("Versão:", versao)</span>
<span class="cm">                     ^^^^^^</span>
<span class="vr">NameError: name 'versao' is not defined</span></pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>Traceback (most recent call last)</td>
      <td><strong>Aviso de que o Python vai mostrar a sequência de chamadas que levou ao erro.</strong> No NameError, quase sempre há uma única linha indicada, porque o Python detecta o problema assim que encontra o nome desconhecido.</td>
    </tr>
    <tr>
      <td>^^^^^^</td>
      <td><strong>O cursor sublinha o nome problemático.</strong> Versões mais recentes do Python (3.11+) sublinham toda a expressão que causou o erro, tornando o diagnóstico ainda mais direto.</td>
    </tr>
    <tr class="bug">
      <td>name 'versao' is not defined</td>
      <td><strong>O Python diz exatamente qual nome não encontrou.</strong> Aqui, <code>versao</code> nunca foi definida. A solução pode ser defini-la antes de usar, ou verificar se o nome está escrito certo.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> NameError</div>
    <img src="img/085.png" alt="NameError">
  </div>





  <p>O <strong>ModuleNotFoundError</strong> acontece quando o código tenta importar uma biblioteca que não está instalada. É o mais simples de resolver: a mensagem diz exatamente qual módulo está faltando, e o <code>pip install</code> resolve.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">codigo_com_erro.py</div>
    </div>
    <pre><span class="kw">import</span> <span class="er">warningsarnings</span>
<span class="fn">print</span>(<span class="st">"Pronto!"</span>)</pre>
  </div>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">terminal</div>
    </div>
    <pre><span class="cm">Traceback (most recent call last):</span>
<span class="cm">  File "codigo_com_erro.py", line 1, in &lt;module&gt;</span>
<span class="cm">    import warningsarnings</span>
<span class="vr">ModuleNotFoundError: No module named 'warningsarnings'</span></pre>
  </div>

  <table class="code-ann">
    <tr class="bug">
      <td>No module named 'warningsarnings'</td>
      <td><strong>O nome entre aspas é exatamente o que o Python tentou importar e não encontrou.</strong> Aqui o nome não existe de verdade, é um typo de <code>warnings</code>. Na prática, quando isso acontece com uma biblioteca real, a correção é rodar <code>pip install nome_da_biblioteca</code> no terminal e tentar de novo.</td>
    </tr>
  </table>



  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> ModuleNotFoundError</div>
    <img src="img/086.png" alt="ModuleNotFoundError">
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Tem jeito mais rápido de encontrar o erro sem ler tudo isso?</div>
  </div>

  <p>Sim. O atalho prático é sempre ler de baixo para cima. A última linha diz o tipo e a descrição, que é o mais importante. A penúltima mostra o trecho do código. E o "File ..., line N" diz onde ir. Com esse hábito, a leitura fica muito mais rápida do que parece agora.</p>

  <div class="lousa">
    <div class="lousa-title">3 passos para ler qualquer erro</div>
    <div class="lousa-row"><span class="bul">1</span><span><strong>Última linha:</strong> tipo do erro e descrição. É o diagnóstico.</span></div>
    <div class="lousa-row"><span class="bul">2</span><span><strong>"File ..., line N":</strong> vá para essa linha no código.</span></div>
    <div class="lousa-row"><span class="bul">3</span><span><strong>O trecho reproduzido e o <code>^</code>:</strong> o Python aponta onde parou. Corrija a partir daí.</span></div>
  </div>

  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa para o café!</h3>
    <p>Levanta, toma um café, e a gente segue!</p>
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Nunca entendi direito o que acontece quando o código manda a mensagem pro GPT. O que está rolando por baixo?</div>
  </div>

  <p>Não é mágica, é uma sequência bem definida de passos. Cada vez que o usuário digita algo e aperta Enter, o código executa exatamente esta cadeia, sempre na mesma ordem:</p>

  <div class="lousa">
    <div class="lousa-title">o que acontece a cada mensagem enviada</div>
    <div class="lousa-row"><span class="bul">1</span><span><strong>input()</strong> captura o texto digitado pelo usuário</span></div>
    <div class="lousa-row"><span class="bul">2</span><span><strong>normalizar()</strong> converte para minúsculas e remove acentos, quando usamos</span></div>
    <div class="lousa-row"><span class="bul">3</span><span><strong>mensagens.append()</strong> adiciona a pergunta ao histórico com role "user"</span></div>
    <div class="lousa-row"><span class="bul">4</span><span><strong>client.chat.completions.create()</strong> envia o histórico completo para a API pela internet</span></div>
    <div class="lousa-row"><span class="bul">5</span><span><strong>OpenAI recebe</strong> o system prompt + histórico + pergunta e processa com o modelo</span></div>
    <div class="lousa-row"><span class="bul">6</span><span><strong>A API devolve</strong> um objeto com choices, usage e outros campos</span></div>
    <div class="lousa-row"><span class="bul">7</span><span><strong>choices[0].message.content</strong> extrai o texto da resposta</span></div>
    <div class="lousa-row"><span class="bul">8</span><span><strong>mensagens.append()</strong> adiciona a resposta ao histórico com role "assistant"</span></div>
    <div class="lousa-row"><span class="bul">9</span><span><strong>print()</strong> exibe a resposta para o usuário</span></div>
  </div>

  <p>Repara no passo 4: nós enviamos o histórico <strong>completo</strong> a cada chamada. O GPT não tem memória própria entre chamadas. O que parece ser "memória" do chatbot é o histórico que o nosso código acumula e reenvia. Cada nova pergunta manda de volta tudo que já foi dito antes, e é por isso que o histórico cresce e o custo cresce junto.</p>

  <p>E repara no passo 6: o objeto que a API devolve contém muito mais do que só o texto. O campo <code>usage</code> que usamos para medir tokens está ali dentro, junto com o modelo usado e o motivo de parada da resposta. As três roles também fazem parte desse fluxo: <code>system</code> são instruções do desenvolvedor, <code>user</code> são mensagens do usuário, e <code>assistant</code> são as respostas anteriores do próprio GPT. Misturar essas roles ou usar a errada pode fazer o GPT ignorar instruções importantes.</p>

  <p>💡Vou aproveitar essa revisão para incluir um elemento que vimos mas não falamos dele com carinho 😁. É a função <code>normalizar()</code> que vale a pena entender direitinho.</p>

  <p>É uma linha densae para entender o que a função faz, precisamos de dois conceitos. O primeiro é <strong>Unicode</strong>: o padrão internacional que define como cada caractere do mundo, letras, símbolos, acentos e emojis, é representado dentro do computador. Cada caractere tem um número único. O "a" é U+0061. O "á" com acento agudo é U+00E1. São caracteres diferentes. O segundo conceito é a <strong>normalização NFD</strong>. O "á" pode ser guardado de dois jeitos: como um caractere único e composto (U+00E1), ou como dois caracteres separados, o "a" base (U+0061) mais a marca do acento (U+0301). A normalização NFD faz essa decomposição: ela separa cada letra da sua marca de acento. Depois da decomposição, os acentos ficam como caracteres independentes com categoria "Mn" (Non-spacing Mark), e é exatamente essa categoria que nós filtramos fora. Sem esse passo de decomposição, o filtro não consegue remover os acentos de letras compostas como "á", "ç" ou "ã" do dia a dia.</p>

  <p>Veja a função completa e correta, com as três linhas:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">normalizar() - versão correta com NFD</div>
    </div>
    <pre><span class="kw">import</span> unicodedata
<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>
<span class="vr">entrada</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Digite uma palavra ou frase: "</span>)
<span class="vr">resultado</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">entrada</span>)
<span class="fn">print</span>(<span class="vr">resultado</span>)</pre>
  </div>


  <table class="code-ann">
    <tr>
      <td>texto.lower()</td>
      <td><strong>Converte tudo para minúsculas.</strong> "HORA", "Hora" e "hora" viram todos "hora". Passo 1 da padronização.</td>
    </tr>
    <tr>
      <td>normalize("NFD", texto)</td>
      <td><strong>Decompõe cada caractere acentuado em dois: a letra base e a marca de acento.</strong> "á" (um caractere) vira "a" + "´" (dois caracteres separados). Sem esse passo, o filtro seguinte não consegue remover os acentos de caracteres compostos como "á", "ç" ou "ã".</td>
    </tr>
    <tr>
      <td>category(c) != "Mn"</td>
      <td><strong>Testa se o caractere é uma marca diacrítica.</strong> Depois do NFD, todos os acentos e cedilhas são caracteres com categoria "Mn". Essa condição mantém as letras base e descarta os acentos.</td>
    </tr>
    <tr>
      <td>"".join(c for c ...)</td>
      <td><strong>Percorre o texto caractere por caractere e monta uma nova string.</strong> O <code>for c in texto</code> pega um caractere de cada vez. O <code>if</code> filtra os que não são "Mn". O <code>"".join()</code> junta tudo sem espaço, formando o texto limpo.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> normalizar() com NFD testada no terminal</div>
    <img src="img/087.png" alt="Função normalizar com NFD testada com acentos variados">
  </div>



 <div class="atencao">
    <strong>Já vimos </strong> a função <code>normalizar()</code>em outras aulas, mas sem o passo <code>unicodedata.normalize("NFD", ...)</code>. Para textos onde o usuário digita com acentos compostos, como "horário" ou "sáir", essa versão incompleta pode não funcionar corretamente.
  </div>

  <p>Agora é a sua vez.</p>

  <div class="exercise">
    <span class="ex-tag">⚡ exercício 031 - leitura de erros I</span>
    <h3>Encontre e corrija os dois erros neste código <span class="ex-diff diff-1">iniciante</span></h3>
    <ol>
      <li>Copie o código abaixo para um arquivo <code>031_Exercicio.py</code></li>
      <li>Rode sem alterar nada e observe a mensagem de erro no terminal</li>
      <li>Use os 3 passos: leia a última linha, vá à linha indicada, corrija</li>
      <li>Rode de novo. Se aparecer outro erro, repita até funcionar</li>
    </ol>
    <div class="cblock" style="margin-top:16px">
      <div class="cblock-head">
        <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
        <div class="cfname">031_Exercicio.py - com erros</div>
      </div>
      <pre><span class="kw">def</span> <span class="fn">apresentar</span>(<span class="vr">nome</span>, <span class="vr">funcao</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Olá! Sou "</span> <span class="op">+</span> <span class="vr">nome</span> <span class="op">+</span> <span class="st">", seu assistente de "</span> <span class="op">+</span> <span class="vr">funcao</span> <span class="op">+</span> <span class="st">"."</span>
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="vr">resultado</span> <span class="op">=</span> <span class="fn">apresentar</span>(<span class="st">"Max"</span> <span class="er"><span class="st">"suporte"</span></span>)
<span class="fn">print</span>(<span class="vr">resultado</span>)
<span class="fn">print</span>(<span class="st">"Modelo:"</span>, <span class="er">modelo</span>)</pre>
    </div>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// os dois erros e como corrigi-los</span>
        <p style="font-size:.88rem;margin:10px 0 6px;color:var(--text2);">Erro 1 - SyntaxError na linha 5: falta uma vírgula entre os dois argumentos de <code>apresentar()</code>. O correto é <code>apresentar("Max", "suporte")</code>.</p>
        <p style="font-size:.88rem;margin:6px 0 12px;color:var(--text2);">Erro 2 - NameError na linha 7: <code>modelo</code> é usada sem ter sido definida. Basta definir antes do print, por exemplo <code>modelo = "gpt-4o-mini"</code>.</p>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">031_Exercicio.py - corrigido</div>
          </div>
          <pre><span class="kw">def</span> <span class="fn">apresentar</span>(<span class="vr">nome</span>, <span class="vr">funcao</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Olá! Sou "</span> <span class="op">+</span> <span class="vr">nome</span> <span class="op">+</span> <span class="st">", seu assistente de "</span> <span class="op">+</span> <span class="vr">funcao</span> <span class="op">+</span> <span class="st">"."</span>
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="vr">modelo</span> <span class="op">=</span> <span class="st">"gpt-4o-mini"</span>
<span class="vr">resultado</span> <span class="op">=</span> <span class="fn">apresentar</span>(<span class="st">"Max"</span>, <span class="st">"suporte"</span>)
<span class="fn">print</span>(<span class="vr">resultado</span>)
<span class="fn">print</span>(<span class="st">"Modelo:"</span>, <span class="vr">modelo</span>)</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="exercise">
    <span class="ex-tag">⚡ exercício 032 - leitura de erros II</span>
    <h3>Indentação quebrada e variável sumida <span class="ex-diff diff-1">iniciante</span></h3>
    <ol>
      <li>Copie o código para <code>032_Exercicio.py</code> e rode sem alterar</li>
      <li>O código tem um IndentationError e um NameError, corrija um de cada vez</li>
      <li>Após cada correção, rode novamente para ver se restam outros erros</li>
      <li>O código correto deve imprimir saudação e encerrar ao digitar "sair"</li>
    </ol>
    <div class="cblock" style="margin-top:16px">
      <div class="cblock-head">
        <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
        <div class="cfname">032_Exercicio.py - com erros</div>
      </div>
      <pre><span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado. Digite 'sair' para encerrar."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="er">break</span>
        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Olá!"</span>, <span class="er">versao_bot</span>)
        <span class="kw">else</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi."</span>)

<span class="fn">chatbot</span>()</pre>
    </div>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// dois erros, duas correções</span>
        <p style="font-size:.88rem;margin:10px 0 6px;color:var(--text2);">IndentationError: o <code>break</code> está no mesmo nível do <code>if</code>, mas deveria estar um nível dentro. Adicione 4 espaços extras antes do <code>break</code>.</p>
        <p style="font-size:.88rem;margin:6px 0 12px;color:var(--text2);">NameError: <code>versao_bot</code> não foi definida. Defina antes de chamar <code>chatbot()</code>, por exemplo <code>versao_bot = "v1.0"</code>.</p>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">032_Exercicio.py - corrigido</div>
          </div>
          <pre><span class="vr">versao_bot</span> <span class="op">=</span> <span class="st">"v1.0"</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="st">"Chat iniciado. Digite 'sair' para encerrar."</span>)
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="kw">break</span>
        <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">user</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Olá!"</span>, <span class="vr">versao_bot</span>)
        <span class="kw">else</span>:
            <span class="fn">print</span>(<span class="st">"Bot: Não entendi."</span>)

<span class="fn">chatbot</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="exercise">
    <span class="ex-tag">⚡ exercício 033 - diagnostique sem rodar</span>
    <h3>Três mensagens de erro para identificar e resolver <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Rode o código e identifique os erros e suas possíveis soluções</li>
      <li>Agora é leitura e raciocínio</li>
      <li>Coloquer suas respostas como comentários</li>
    </ol>
    <div class="cblock" style="margin-top:16px">
      <div class="cblock-head">
        <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
        <div class="cfname">Verificação de Erros</div>
      </div>
<pre><span class="kw">import</span> <span class="er">warningsarnings</span>

<span class="kw">def</span> <span class="fn"><span class="er">saudacao(nome)</span></span>
    <span class="vr">mensagem</span> <span class="op">=</span> <span class="st">"Olá, "</span> <span class="op">+</span> <span class="vr">nome</span> <span class="op">+</span> <span class="st">"!"</span>
    <span class="kw">return</span> <span class="vr">mensagem</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="fn">saudacao</span>(<span class="st">"visitante"</span>))
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="er">break</span>
        <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="er">resposta</span>)

<span class="fn">chatbot</span>()</pre>
    </div>


    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// diagnóstico dos três cenários</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">033_Exercicio.py</div>
          </div>


<pre><span class="kw"></span><span class="cm">#biblioteca não existe, remova ou substitua por uma real</span>
<span class="kw">def</span> <span class="fn">saudacao</span>(<span class="vr">nome</span>):  <span class="cm"># faltava o : no final</span>
    <span class="vr">mensagem</span> <span class="op">=</span> <span class="st">"Olá, "</span> <span class="op">+</span> <span class="vr">nome</span> <span class="op">+</span> <span class="st">"!"</span>
    <span class="kw">return</span> <span class="vr">mensagem</span>

<span class="kw">def</span> <span class="fn">chatbot</span>():
    <span class="fn">print</span>(<span class="fn">saudacao</span>(<span class="st">"visitante"</span>))
    <span class="kw">while</span> <span class="kw">True</span>:
        <span class="vr">user</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">lower</span>()
        <span class="kw">if</span> <span class="vr">user</span> <span class="op">==</span> <span class="st">"sair"</span>:
            <span class="kw">break</span>  <span class="cm">#faltava indentação</span>
        <span class="vr">resposta</span> <span class="op">=</span> <span class="st">"Não entendi, pode repetir?"</span>  <span class="cm">#variável não estava definida</span>
        <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">resposta</span>)

<span class="fn">chatbot</span>()</pre>


        </div>
      </div>
    </div>
  </div>

  <div class="exercise">
    <span class="ex-tag">⚡ exercício 034 - normalizar() do zero</span>
    <h3>Escreva a função de normalização com NFD sem consultar o material <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Crie o arquivo <code>034_Exercicio.py</code></li>
      <li>Escreva a função <code>normalizar(texto)</code> com as três linhas: lower, NFD, join com filtro "Mn"</li>
      <li>Teste com pelo menos estes cinco inputs e imprima o resultado de cada um: <code>"Horário"</code>, <code>"SAIR"</code>, <code>"olá tudo bem?"</code>, <code>"ação"</code>, <code>"São Paulo"</code></li>
      <li>Todos devem sair sem acentos e em minúsculas</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// normalizar() com os testes</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">034_Exercicio.py</div>
          </div>
          <pre><span class="kw">import</span> unicodedata

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="vr">testes</span> <span class="op">=</span> [<span class="st">"Horário"</span>, <span class="st">"SAIR"</span>, <span class="st">"olá tudo bem?"</span>, <span class="st">"ação"</span>, <span class="st">"São Paulo"</span>]

<span class="kw">for</span> <span class="vr">t</span> <span class="kw">in</span> <span class="vr">testes</span>:
    <span class="fn">print</span>(<span class="st">f"'{t}' -> '{normalizar(t)}'"</span>)</pre>
        </div>
      </div>
    </div>
  </div>


  <div class="exercise">
    <span class="ex-tag">⚡ exercício 035 - chatbot revisado do zero</span>
    <h3>Construa um chatbot completo usando tudo que revisamos <span class="ex-diff diff-3">avançado</span></h3>
    <ol>
      <li>Crie o arquivo <code>035_Exercicio.py</code> com um chatbot para um tema à sua escolha</li>
      <li>Use <code>normalizar()</code> com NFD no input do usuário</li>
      <li>Escreva o system prompt com os quatro elementos: Contexto, Tarefa, Formato e Restrições</li>
      <li>Inclua <code>try/except</code> na chamada à API</li>
      <li>Acumule <code>total_entrada</code> e <code>total_saida</code> com <code>resposta.usage</code> e mostre o resumo ao digitar "sair"</li>
      <li>Limite o histórico a 10 mensagens</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// exemplo: assistente de biblioteca</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">035_Exercicio.py</div>
          </div>
          <pre><span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">import</span> os, unicodedata, httpx
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv

<span class="fn">load_dotenv</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="vr">mensagens</span> <span class="op">=</span> [
    {
        <span class="st">"role"</span>: <span class="st">"system"</span>,
        <span class="st">"content"</span>: (
            <span class="cm"># CONTEXTO</span>
            <span class="st">"Você é a assistente virtual da Biblioteca Municipal Leitura Viva. "</span>
            <span class="cm"># TAREFA</span>
            <span class="st">"Responda apenas sobre acervo, empréstimos, horários e eventos. "</span>
            <span class="st">"Para outros assuntos, diga educadamente que só pode ajudar com a biblioteca. "</span>
            <span class="cm"># FORMATO</span>
            <span class="st">"Responda em no máximo 3 frases. "</span>
            <span class="cm"># RESTRIÇÕES</span>
            <span class="st">"Use tom acolhedor. Responda sempre em português."</span>
        )
    }
]

<span class="vr">total_entrada</span> <span class="op">=</span> <span class="nm">0</span>
<span class="vr">total_saida</span>   <span class="op">=</span> <span class="nm">0</span>

<span class="fn">print</span>(<span class="st">"Leitura Viva: Olá! Como posso ajudar?"</span>)
<span class="fn">print</span>(<span class="st">"(Digite 'sair' para encerrar)\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">entrada</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()

    <span class="kw">if</span> <span class="fn">normalizar</span>(<span class="vr">entrada</span>) <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"\n-- Resumo da sessão --"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de entrada : {total_entrada}"</span>)
        <span class="fn">print</span>(<span class="st">f"Tokens de saída   : {total_saida}"</span>)
        <span class="fn">print</span>(<span class="st">f"Total             : {total_entrada + total_saida}"</span>)
        <span class="vr">custo</span> <span class="op">=</span> (<span class="vr">total_entrada</span> <span class="op">*</span> <span class="nm">0.00000015</span>) <span class="op">+</span> (<span class="vr">total_saida</span> <span class="op">*</span> <span class="nm">0.0000006</span>)
        <span class="fn">print</span>(<span class="st">f"Custo estimado    : U${custo:.6f}"</span>)
        <span class="fn">print</span>(<span class="st">"----------------------"</span>)
        <span class="kw">break</span>

    <span class="kw">if not</span> <span class="vr">entrada</span>:
        <span class="kw">continue</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">entrada</span>})

    <span class="kw">try</span>:
        <span class="vr">resposta</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4o-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">120</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.3</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resposta</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
        <span class="vr">total_entrada</span> <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">prompt_tokens</span>
        <span class="vr">total_saida</span>   <span class="op">+=</span> <span class="vr">resposta</span>.<span class="vr">usage</span>.<span class="vr">completion_tokens</span>
    <span class="kw">except</span> <span class="fn">Exception</span> <span class="kw">as</span> <span class="vr">e</span>:
        <span class="fn">print</span>(<span class="st">f"Erro: {e}"</span>)
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não consegui responder agora. Tente novamente."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="fn">print</span>(<span class="st">f"Leitura Viva: {texto}\n"</span>)

    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">
      <a class="dl-item" href="arquivos/031_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">031_Exercicio.py</div>
          <div class="dl-desc">Exercício 31 - código com SyntaxError e NameError para encontrar e corrigir</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>
      <a class="dl-item" href="arquivos/032_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">032_Exercicio.py</div>
          <div class="dl-desc">Exercício 32 - código com IndentationError e NameError para encontrar e corrigir</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>
      <a class="dl-item" href="arquivos/033_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">033_Exercicio.py</div>
          <div class="dl-desc">Exercício 33 - diagnóstico de três mensagens de terminal sem rodar código</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>
      <a class="dl-item" href="arquivos/034_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">034_Exercicio.py</div>
          <div class="dl-desc">Exercício 34 - normalizar() com NFD escrita do zero e testada com cinco entradas</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>
      <a class="dl-item" href="arquivos/035_Exercicio.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">035_Exercicio.py</div>
          <div class="dl-desc">Exercício 35 - chatbot completo com normalizar, system prompt estruturado, try/except e custo de sessão</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>
    </div>
  </div>

  <div class="ready">
    <span class="re">🎉</span>
    <h2>Pronto para a Aula 5!</h2>
    <p>Nos vemos lá!</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="aula4.php">← Aula 4</a>
    <a class="nav-link next" href="aula5.php">Aula 5 →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>

<footer>
  <span>Chatbots com Python · revisão</span>
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
