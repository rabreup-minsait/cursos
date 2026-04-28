<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aula 7 - Chatbots com Python</title>
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
.lousa-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; color:#6aaa78; margin-bottom:10px; display:block; }
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
.dc{color:#0e7a5a;} /* decorator */
.code-ann { margin:16px 0 24px; border-collapse:collapse; width:100%; }
.code-ann tr { border-bottom:1px solid var(--border); }
.code-ann tr:last-child { border-bottom:none; }
.code-ann td { padding:8px 10px; font-size:.85rem; vertical-align:top; line-height:1.65; }
.code-ann td:first-child { font-family:'Fira Code',monospace; font-size:.78rem; white-space:nowrap; color:var(--accent); background:var(--accent-lt); border-radius:4px; width:1%; padding:8px 12px; }
.code-ann td:last-child { color:var(--text2); }
.code-ann td strong { color:var(--text); }
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
.ex-ans-body { display:none; }
.ex-ans-body.visible { display:block; }
.btn-ans { display:inline-flex; align-items:center; gap:6px; font-family:'Fira Code',monospace; font-size:.75rem; font-weight:600; color:var(--green); background:var(--green-lt); border:1.5px solid rgba(13,110,80,.25); border-radius:5px; padding:6px 14px; cursor:pointer; transition:all .15s; margin-top:4px; letter-spacing:.03em; }
.btn-ans:hover { background:#d0ece3; border-color:rgba(13,110,80,.5); }
.cmd-block { background:#1e1916; border-radius:7px; padding:13px 16px; margin:18px 0; font-family:'Fira Code',monospace; font-size:12.5px; color:#c8e4cc; line-height:2; }
.cmd-block .prompt { color:#5ad68a; user-select:none; }
.cmd-block .cmd { color:#e8f0fb; }
.cmd-block .cmt { color:#6aaa78; font-style:italic; }
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
    <a class="tb-btn" href="../index.html">⊞ índice</a>
    <span class="tb-lesson">aula 07 · interface web real</span>
    <a class="tb-btn" href="aula6.php">←</a>
    <a class="tb-btn next" href="aula8.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">aula 07</span>
    <h1>Do terminal<br><em>para o mundo real</em></h1>
    <p>Até agora, tudo o que construímos vive dentro do terminal do seu computador. Nesta aula, o chatbot vai ganhar um endereço de rede e uma interface que qualquer pessoa pode abrir no navegador.</p>
  </div>

  <p>Faz um teste rápido. Fecha o terminal onde o chatbot estava rodando. Pronto, ele sumiu. Agora imagina que você quer mostrar esse chatbot para o seu chefe, para um cliente, ou para um amigo. A pessoa teria que instalar o Python, baixar o código, abrir o terminal, rodar o comando certo... Ninguém vai fazer isso. Para o chatbot virar um produto de verdade, ele precisa estar num endereço que qualquer pessoa acessa pelo navegador, do celular, do computador de casa, de qualquer lugar.</p>

  <p>Pensa no WhatsApp. Quando você manda uma mensagem, o texto sai do seu celular, viaja pela internet, chega num servidor, é processado, e a resposta volta para a tela. Você nunca vê o servidor. Nunca instala nada no computador dele. Só usa a interface. É exatamente isso que nós vamos construir agora, uma versão simples desse fluxo para o nosso chatbot.</p>

  <div class="lousa">
    <div class="lousa-title">o caminho da mensagem</div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Você</strong> digita no navegador e clica em enviar</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>A <strong>página web</strong> (HTML + JavaScript) empacota a mensagem e envia pela internet</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>O <strong>servidor Python</strong> recebe, processa, chama a IA e monta a resposta</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>A resposta volta para a <strong>página web</strong>, que exibe na tela</span></div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">▶</div> Fluxo visual do sistema</div>
    <img src="img/091.png" alt="Diagrama mostrando o fluxo: usuário no navegador → HTML/JS → FastAPI (Python) → OpenAI → resposta volta pelo mesmo caminho">
  </div>

  <p>Para essa viagem funcionar, os dois lados, o navegador e o servidor, precisam falar a mesma língua. Essa língua se chama <strong>HTTP</strong>.</p>

  <p>HTTP vem de <em>HyperText Transfer Protocol</em>, que traduzindo fica "protocolo de transferência de hipertexto". Parece complicado, mas a ideia é simples. Um protocolo é um acordo entre dois lados sobre como a conversa vai funcionar. Pensa numa ligação telefônica. Você liga, o outro atende e diz "alô", você se identifica, faz o pedido, e a outra pessoa responde. Vocês dois sabem a ordem, sabem o formato. Se alguém atendesse e começasse a cantar ópera, a conversa não ia funcionar. O HTTP é esse tipo de acordo, só que entre computadores. Toda vez que você abre uma página no navegador, quando nosso chatbot chamou a API da OpenAI nas aulas anteriores, ou quando o JavaScript vai falar com nosso servidor agora, o que acontece por baixo é sempre uma troca de mensagens HTTP.</p>

  <p>Cada mensagem HTTP tem três partes. O <strong>método</strong> diz a intenção, como GET (quero buscar algo) ou POST (quero enviar dados). O <strong>endereço</strong> diz para onde a mensagem vai, como <code>/chat</code>. E o <strong>corpo</strong> carrega os dados em si, que no nosso caso será um texto em JSON. Quando falamos <code>@app.post("/chat")</code> no código mais para frente, estamos dizendo exatamente isso: "quando chegar uma mensagem HTTP com método POST para o endereço /chat, chame esta função".</p>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Mas na Aula 3 a gente já mandava mensagens para a API da OpenAI. Aquilo era HTTP também?</div>
  </div>

  <p>Era sim! A biblioteca <code>openai</code> faz requisições HTTP por baixo dos panos, você só não via porque ela esconde a complexidade. A diferença agora é que <em>nós</em> vamos estar do outro lado. Em vez de mandar mensagens para o servidor da OpenAI, nós vamos criar o nosso próprio servidor que recebe mensagens.</p>

  <p>Para isso, vamos usar duas ferramentas novas. A primeira é o <strong>FastAPI</strong>, uma biblioteca Python que transforma funções comuns em endpoints, aqueles endereços de rede que respondem requisições HTTP. Funciona assim: nós criamos um objeto chamado <code>app</code>, e qualquer função que colocarmos um <code>@app.post()</code> em cima vira automaticamente um ponto de acesso pela rede. A segunda ferramenta é o <strong>uvicorn</strong>, que é o servidor que fica rodando, escutando as visitas e repassando para o código certo. Pensa assim. O FastAPI é o cardápio do restaurante, define o que pode ser pedido e o que cada pedido faz. O uvicorn é o garçom, fica na porta, recebe os pedidos e leva para a cozinha.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">▶</div> Como o FastAPI e o uvicorn trabalham juntos</div>
    <img src="img/091b.png" alt="Diagrama: uvicorn escuta a porta 8000, recebe a requisição HTTP, repassa para o FastAPI que chama a função decorada">
  </div>

  <p>Para iniciar os dois juntos, usamos o comando <code>python -m uvicorn main:app --reload</code> no terminal. O trecho <code>main:app</code> diz ao uvicorn onde encontrar a aplicação, significando "no arquivo <code>main.py</code>, procure o objeto chamado <code>app</code>". O <code>--reload</code> é um atalho de desenvolvimento, faz o servidor reiniciar sozinho toda vez que você salvar o arquivo, sem precisar parar e rodar de novo manualmente.</p>

  <div class="atencao">
    <strong>Atenção:</strong> <code>python main.py</code> não funciona aqui. Esse comando executa o arquivo mas não abre a porta para receber visitas. É o uvicorn que faz o papel de abrir a porta e ficar escutando. Sempre use <code>python -m uvicorn main:app --reload</code>.
  </div>

  <p>Quando o uvicorn inicia, ele abre uma <strong>porta</strong> no seu computador. Uma porta é como um ramal dentro de um número de telefone. O endereço do computador é <code>127.0.0.1</code> (que sempre significa "este computador") e a porta padrão do uvicorn é <code>8000</code>. Juntando os dois, o endereço completo fica <code>http://127.0.0.1:8000</code>. Se você quiser rodar dois servidores ao mesmo tempo, cada um precisa usar um ramal diferente, como <code>8000</code> e <code>8001</code>.</p>

  <p>O FastAPI ainda traz dois bônus que facilitam muito a vida. O primeiro é a <strong>documentação automática</strong>. Ao acessar <code>http://127.0.0.1:8000/docs</code> no navegador, aparece uma página onde você vê todos os seus endpoints e pode testá-los direto ali, sem nenhuma ferramenta extra. O segundo é a <strong>validação automática</strong> com o Pydantic. Nós declaramos uma classe simples dizendo que esperamos um campo chamado <code>texto</code>, e o FastAPI garante que, se chegar algo diferente, ele devolve um erro claro em vez de deixar o código travar. É como um formulário que verifica se você preencheu todos os campos antes de enviar.</p>

  <p>E por falar em erros, uma coisa que vai aparecer bastante daqui para frente é o <strong>código de status HTTP</strong>. Esse número acompanha toda resposta e diz, de forma rápida, o que aconteceu. O <strong>200</strong> significa que tudo funcionou. O <strong>422</strong> aparece quando os dados enviados não batem com o que era esperado. O <strong>500</strong> é erro interno do servidor, normalmente um problema no código. Quando algo não funcionar, olhe esse número primeiro.</p>

  <p>Antes de escrever o código, uma dica prática sobre organização de arquivos. O <code>main.py</code> (servidor) e o <code>index.html</code> (interface) não precisam estar na mesma pasta, já que rodam em processos separados, mas é uma boa prática manter os dois juntos durante o desenvolvimento. A comunicação entre eles acontece pela rede, não pelo sistema de arquivos.</p>

  <p>Tem mais dois conceitos novos que vão aparecer no código e que vale entender agora. O primeiro é o <strong>decorador</strong>. Um decorador é uma linha que começa com <code>@</code> e fica logo acima de uma função. Ele modifica o comportamento dessa função sem que você precise mexer nela por dentro. No caso do FastAPI, <code>@app.post("/chat")</code> é como colocar uma plaquinha numa porta dizendo "quem bater aqui com um POST vai ser atendido pela função abaixo". O segundo conceito é a diferença entre <strong>GET</strong> e <strong>POST</strong>. GET é usado para buscar informações. POST é usado para enviar dados. Como estamos enviando mensagens do usuário, usamos POST.</p>

  <div class="lousa">
    <div class="lousa-title">o que instalar e como rodar</div>
    <div class="lousa-row"><span class="bul">◆</span><span>instalar: <code>pip install fastapi uvicorn openai python-dotenv httpx</code></span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>rodar: <code>python -m uvicorn main:app --reload</code></span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>testar: abrir <code>http://127.0.0.1:8000/docs</code> no navegador</span></div>
  </div>

  <p>Vamos ao código. A ideia é pegar o chatbot que desenvolvemos nas últimas aulas e transformá-lo num servidor FastAPI. O perfil do usuário, a detecção de nome e gostos, a injeção no system prompt, o histórico, tudo continua igual. A diferença é que, em vez do loop <code>while True</code> com <code>input()</code>, agora temos uma função decorada com <code>@app.post("/chat")</code> que recebe a mensagem como dado da requisição.</p>

  <p>Você já usou <code>global</code> na Aula 6 dentro de <code>limpar_memoria()</code>. Aqui ele tem um papel específico ao FastAPI: como o servidor chama <code>chat()</code> de novo a cada mensagem que chega, sem o <code>global</code> as variáveis <code>perfil</code> e <code>mensagens</code> nasceriam vazias em cada chamada e toda a memória seria perdida. Com ele, todas as chamadas compartilham as mesmas variáveis enquanto o servidor estiver no ar.</p>

<div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">049_main.py</div>
    </div>
    <pre><span class="kw">import</span> warnings
<span class="kw">import</span> urllib3
<span class="kw">import</span> unicodedata
<span class="kw">import</span> httpx
<span class="kw">import</span> os
<span class="kw">from</span> fastapi <span class="kw">import</span> FastAPI
<span class="kw">from</span> pydantic <span class="kw">import</span> BaseModel
<span class="kw">from</span> openai <span class="kw">import</span> OpenAI

warnings.<span class="fn">filterwarnings</span>(<span class="st">"ignore"</span>)
urllib3.<span class="fn">disable_warnings</span>()

<span class="vr">app</span> <span class="op">=</span> <span class="fn">FastAPI</span>()

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span><span class="st">"COLE_SUA_CHAVE_AQUI"</span>,
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="cm"># perfil e histórico ficam vivos enquanto o servidor roda</span>
<span class="vr">perfil</span> <span class="op">=</span> {<span class="st">"nome"</span>: <span class="kw">None</span>, <span class="st">"gostos"</span>: []}
<span class="vr">mensagens</span> <span class="op">=</span> [
    {<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="st">"Você é um assistente direto e objetivo. Responda de forma curta."</span>}
]

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="cm"># modelo da requisição: define que esperamos um campo "texto"</span>
<span class="kw">class</span> <span class="fn">Pergunta</span>(<span class="fn">BaseModel</span>):
    <span class="vr">texto</span>: <span class="bi">str</span>

<span class="dc">@app.get</span>(<span class="st">"/"</span>)
<span class="kw">def</span> <span class="fn">raiz</span>():
    <span class="kw">return</span> {<span class="st">"mensagem"</span>: <span class="st">"API do chatbot funcionando!"</span>}

<span class="dc">@app.post</span>(<span class="st">"/chat"</span>)
<span class="kw">def</span> <span class="fn">chat</span>(<span class="vr">pergunta</span>: <span class="fn">Pergunta</span>):
    <span class="kw">global</span> <span class="vr">perfil</span>, <span class="vr">mensagens</span>
    <span class="vr">texto_usuario</span> <span class="op">=</span> <span class="vr">pergunta</span>.<span class="vr">texto</span>.<span class="fn">strip</span>()
    <span class="vr">texto_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">texto_usuario</span>)

    <span class="kw">if not</span> <span class="vr">texto_usuario</span>:
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">""</span>}

    <span class="kw">if</span> <span class="st">"meu nome e"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">nome</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">split</span>(<span class="st">"meu nome é"</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>().<span class="fn">title</span>()
        <span class="vr">perfil</span>[<span class="st">"nome"</span>] <span class="op">=</span> <span class="vr">nome</span>
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Prazer, {nome}!"</span>}

    <span class="kw">if</span> <span class="st">"eu gosto de"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">gosto</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">lower</span>().<span class="fn">split</span>(<span class="st">"eu gosto de"</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>()
        <span class="vr">gosto_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">gosto</span>)
        <span class="kw">if</span> <span class="vr">gosto_norm</span> <span class="kw">not in</span> [<span class="fn">normalizar</span>(<span class="vr">g</span>) <span class="kw">for</span> <span class="vr">g</span> <span class="kw">in</span> <span class="vr">perfil</span>[<span class="st">"gostos"</span>]]:
            <span class="vr">perfil</span>[<span class="st">"gostos"</span>].<span class="fn">append</span>(<span class="vr">gosto</span>)
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Anotado! Você gosta de {gosto}."</span>}
        <span class="kw">else</span>:
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Já sei que você gosta de {gosto}!"</span>}

    <span class="cm"># injeta contexto no system prompt</span>
    <span class="vr">extra</span> <span class="op">=</span> <span class="st">""</span>
    <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"nome"</span>]:
        <span class="vr">extra</span> <span class="op">+=</span> <span class="st">f"O nome do usuário é {perfil['nome']}. "</span>
    <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"gostos"</span>]:
        <span class="vr">extra</span> <span class="op">+=</span> <span class="st">f"O usuário gosta de: {', '.join(perfil['gostos'])}. "</span>
    <span class="vr">mensagens</span>[<span class="nm">0</span>][<span class="st">"content"</span>] <span class="op">=</span> <span class="st">"Você é um assistente direto e objetivo. "</span> <span class="op">+</span> <span class="vr">extra</span> <span class="op">+</span> <span class="st">"Responda de forma curta."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">texto_usuario</span>})

    <span class="kw">try</span>:
        <span class="vr">resp</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4.1-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">80</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.3</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resp</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
    <span class="kw">except</span> <span class="fn">Exception</span>:
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não foi possível processar. Tente novamente."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]

    <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="vr">texto</span>}</pre>
  </div>

  <p>Para rodar, abra o terminal na pasta onde salvou o arquivo e execute:</p>

  <div class="cmd-block">
    <div><span class="prompt">$ </span><span class="cmd">pip install fastapi uvicorn openai python-dotenv httpx</span></div>
    <div><span class="prompt">$ </span><span class="cmd">python -m uvicorn main:app --reload</span></div>
  </div>

  <table class="code-ann">
    <tr>
      <td>app = FastAPI()</td>
      <td><strong>Cria a aplicação.</strong> É o objeto central que registra todos os endpoints. O nome <code>app</code> é o mesmo que aparece no comando <code>uvicorn main:app</code>.</td>
    </tr>
    <tr>
      <td>class Pergunta(BaseModel)</td>
      <td><strong>Define o contrato dos dados.</strong> Ao herdar de <code>BaseModel</code>, o Pydantic verifica automaticamente se o JSON recebido tem o campo <code>texto</code>. Se não tiver, devolve um erro 422 sem o código travar.</td>
    </tr>
    <tr>
      <td>@app.get("/")</td>
      <td><strong>Registra a rota GET no endereço "/".</strong> Quando alguém acessa <code>http://127.0.0.1:8000/</code> no navegador, o FastAPI chama a função <code>raiz()</code>. Serve para verificar se a API está no ar.</td>
    </tr>
    <tr>
      <td>@app.post("/chat")</td>
      <td><strong>Registra a rota POST no endereço "/chat".</strong> Toda vez que o front-end enviar uma mensagem, ela chega aqui. O FastAPI extrai os dados do corpo da requisição e os entrega à função como o parâmetro <code>pergunta</code>, já convertidos para o formato da classe <code>Pergunta</code>.</td>
    </tr>
    <tr>
      <td>def chat(pergunta: Pergunta)</td>
      <td><strong>A função que processa cada mensagem.</strong> O parâmetro <code>pergunta</code> é do tipo <code>Pergunta</code>, então acessamos o texto com <code>pergunta.texto</code>. Essa conversão é feita automaticamente pelo FastAPI.</td>
    </tr>
    <tr>
      <td>global perfil, mensagens</td>
      <td><strong>Garante que a função use as variáveis globais.</strong> Sem isso, cada chamada ao endpoint começaria do zero, como se o servidor não tivesse memória.</td>
    </tr>
    <tr>
      <td>return {"resposta": texto}</td>
      <td><strong>Devolve um dicionário que o FastAPI converte em JSON.</strong> O front-end recebe <code>{"resposta": "..."}</code> e acessa o texto com <code>dados.resposta</code>.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 049 - API rodando e testada pelo /docs</div>
    <img src="img/092.png" alt="FastAPI rodando no terminal e documentação automática no navegador">
  </div>

  <p>Repara numa coisa interessante. Enquanto o servidor estiver rodando, o chatbot lembra de tudo, mesmo que você recarregue a página do navegador. Isso porque a memória vive no processo do servidor, não no navegador. Quando o terminal fecha, aí sim a memória vai embora. Para persistência real entre reinicializações do servidor, precisaríamos de um arquivo, como fizemos na Aula 5.</p>

  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa para o café!</h3>
    <p>Levanta, respira, e quando voltar nós conectamos o HTML com a API.</p>
  </div>

  <p>Voltou? Ótimo. Antes de conectar o HTML, temos dois ajustes importantes no servidor. O primeiro é a proteção da chave. O segundo é o CORS.</p>

  <p>A chave da OpenAI não pode ficar escrita no código. Você já viu isso na Aula 3 com o arquivo <code>.env</code>. Agora vamos um passo além: em vez de usar arquivo, vamos definir a chave como <strong>variável de ambiente</strong> direto no terminal, antes de iniciar o servidor.</p>

  <div class="cmd-block">
    <div><span class="cmt"># Windows PowerShell</span></div>
    <div><span class="prompt">$ </span><span class="cmd">$env:OPENAI_API_KEY="sua-chave-aqui"</span></div>
    <div><span class="prompt">$ </span><span class="cmd">python -m uvicorn main:app --reload</span></div>
    <div></div>
    <div><span class="cmt"># Linux / Mac</span></div>
    <div><span class="prompt">$ </span><span class="cmd">export OPENAI_API_KEY="sua-chave-aqui"</span></div>
    <div><span class="prompt">$ </span><span class="cmd">python -m uvicorn main:app --reload</span></div>
  </div>

  <p>Essa variável vale enquanto o terminal estiver aberto. No código Python, lemos com <code>os.getenv("OPENAI_API_KEY")</code>. O resultado é o mesmo do <code>load_dotenv()</code> que você já conhece, só que sem precisar de arquivo. No código 050 abaixo, usamos os dois juntos: o <code>load_dotenv()</code> carrega o <code>.env</code> se ele existir, e o <code>os.getenv()</code> lê a variável de qualquer fonte. Assim funciona tanto em desenvolvimento quanto em produção.</p>

  <p>Agora o CORS. Tenta imaginar a seguinte situação. Você abre o <code>index.html</code> no navegador. Ele está no seu computador, com o endereço <code>file:///...</code>. O JavaScript tenta mandar uma mensagem para <code>http://127.0.0.1:8000/chat</code>. O navegador olha e pensa: "peraí, a página está num endereço e o servidor está em outro. Isso pode ser perigoso." E bloqueia o pedido. Essa proteção se chama CORS, que vem de <em>Cross-Origin Resource Sharing</em>. Ela existe para impedir que um site malicioso faça requisições em nome do usuário para outro site.</p>

  <p>Para o nosso caso, que é legítimo, precisamos dizer ao servidor: "aceite requisições vindas de qualquer endereço." No FastAPI, fazemos isso adicionando um <strong>middleware</strong>. Um middleware é um código que fica na entrada do servidor, interceptando toda requisição que chega e toda resposta que sai, automaticamente. Registramos uma vez com <code>app.add_middleware()</code> e ele age em tudo, sem precisar tocar em nenhuma função individual.</p>

  <div class="lousa">
    <div class="lousa-title">CORS na prática</div>
    <div class="lousa-row"><span class="bul">◆</span><span>o navegador bloqueia pedidos entre endereços diferentes por segurança</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><code>allow_origins=["*"]</code> libera qualquer endereço, ok para desenvolvimento</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span>em produção, troque o <code>"*"</code> pelo endereço exato do seu front-end</span></div>
  </div>

<div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">050_main.py</div>
    </div>
    <pre><span class="kw">import</span> warnings
<span class="kw">import</span> urllib3
<span class="kw">import</span> unicodedata
<span class="kw">import</span> httpx
<span class="kw">import</span> os
<span class="kw">from</span> fastapi <span class="kw">import</span> FastAPI
<span class="kw">from</span> fastapi.middleware.cors <span class="kw">import</span> CORSMiddleware
<span class="kw">from</span> pydantic <span class="kw">import</span> BaseModel
<span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv

warnings.<span class="fn">filterwarnings</span>(<span class="st">"ignore"</span>)
urllib3.<span class="fn">disable_warnings</span>()
<span class="fn">load_dotenv</span>()

<span class="vr">app</span> <span class="op">=</span> <span class="fn">FastAPI</span>()

<span class="cm"># libera o CORS para qualquer origem (ok para desenvolvimento)</span>
<span class="vr">app</span>.<span class="fn">add_middleware</span>(
    <span class="fn">CORSMiddleware</span>,
    <span class="vr">allow_origins</span><span class="op">=</span>[<span class="st">"*"</span>],
    <span class="vr">allow_methods</span><span class="op">=</span>[<span class="st">"*"</span>],
    <span class="vr">allow_headers</span><span class="op">=</span>[<span class="st">"*"</span>],
)

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">perfil</span> <span class="op">=</span> {<span class="st">"nome"</span>: <span class="kw">None</span>, <span class="st">"gostos"</span>: []}
<span class="vr">mensagens</span> <span class="op">=</span> [
    {<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="st">"Você é um assistente direto e objetivo. Responda de forma curta."</span>}
]

<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>):
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="kw">class</span> <span class="fn">Pergunta</span>(<span class="fn">BaseModel</span>):
    <span class="vr">texto</span>: <span class="bi">str</span>

<span class="dc">@app.get</span>(<span class="st">"/"</span>)
<span class="kw">def</span> <span class="fn">raiz</span>():
    <span class="kw">return</span> {<span class="st">"mensagem"</span>: <span class="st">"API do chatbot funcionando!"</span>}

<span class="dc">@app.post</span>(<span class="st">"/chat"</span>)
<span class="kw">def</span> <span class="fn">chat</span>(<span class="vr">pergunta</span>: <span class="fn">Pergunta</span>):
    <span class="kw">global</span> <span class="vr">perfil</span>, <span class="vr">mensagens</span>
    <span class="vr">texto_usuario</span> <span class="op">=</span> <span class="vr">pergunta</span>.<span class="vr">texto</span>.<span class="fn">strip</span>()
    <span class="vr">texto_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">texto_usuario</span>)

    <span class="kw">if not</span> <span class="vr">texto_usuario</span>:
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">""</span>}

    <span class="kw">if</span> <span class="st">"meu nome e"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">nome</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">split</span>(<span class="st">"meu nome é"</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>().<span class="fn">title</span>()
        <span class="vr">perfil</span>[<span class="st">"nome"</span>] <span class="op">=</span> <span class="vr">nome</span>
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Prazer, {nome}!"</span>}

    <span class="kw">if</span> <span class="st">"eu gosto de"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">gosto</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">lower</span>().<span class="fn">split</span>(<span class="st">"eu gosto de"</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>()
        <span class="vr">gosto_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">gosto</span>)
        <span class="kw">if</span> <span class="vr">gosto_norm</span> <span class="kw">not in</span> [<span class="fn">normalizar</span>(<span class="vr">g</span>) <span class="kw">for</span> <span class="vr">g</span> <span class="kw">in</span> <span class="vr">perfil</span>[<span class="st">"gostos"</span>]]:
            <span class="vr">perfil</span>[<span class="st">"gostos"</span>].<span class="fn">append</span>(<span class="vr">gosto</span>)
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Anotado! Você gosta de {gosto}."</span>}
        <span class="kw">else</span>:
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Já sei que você gosta de {gosto}!"</span>}

    <span class="vr">extra</span> <span class="op">=</span> <span class="st">""</span>
    <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"nome"</span>]:
        <span class="vr">extra</span> <span class="op">+=</span> <span class="st">f"O nome do usuário é {perfil['nome']}. "</span>
    <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"gostos"</span>]:
        <span class="vr">extra</span> <span class="op">+=</span> <span class="st">f"O usuário gosta de: {', '.join(perfil['gostos'])}. "</span>
    <span class="vr">mensagens</span>[<span class="nm">0</span>][<span class="st">"content"</span>] <span class="op">=</span> <span class="st">"Você é um assistente direto e objetivo. "</span> <span class="op">+</span> <span class="vr">extra</span> <span class="op">+</span> <span class="st">"Responda de forma curta."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">texto_usuario</span>})

    <span class="kw">try</span>:
        <span class="vr">resp</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4.1-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">80</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.3</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resp</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
    <span class="kw">except</span> <span class="fn">Exception</span>:
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Não foi possível processar. Tente novamente."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]

    <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="vr">texto</span>}</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>from fastapi.middleware.cors import CORSMiddleware</td>
      <td><strong>Importa o middleware de CORS.</strong> Ele vai interceptar toda resposta que sair do servidor e adicionar os cabeçalhos que o navegador precisa ver para liberar a requisição.</td>
    </tr>
    <tr>
      <td>app.add_middleware(...)</td>
      <td><strong>Registra o middleware na aplicação.</strong> O <code>allow_origins=["*"]</code> libera qualquer endereço, <code>allow_methods=["*"]</code> libera todos os métodos HTTP e <code>allow_headers=["*"]</code> libera todos os cabeçalhos. Em produção, você substituiria o <code>"*"</code> pelo endereço do seu site.</td>
    </tr>
    <tr>
      <td>os.getenv("OPENAI_API_KEY")</td>
      <td><strong>Lê a chave da variável de ambiente.</strong> Se a variável não existir, retorna <code>None</code>. A chave nunca aparece escrita no código.</td>
    </tr>
    <tr>
      <td>load_dotenv()</td>
      <td><strong>Carrega o <code>.env</code> se ele existir.</strong> Você já usou na Aula 3. Aqui ele serve como fallback para desenvolvimento local. Em produção, a variável de ambiente é definida pelo sistema e o <code>.env</code> não é necessário.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 050 - API com CORS e variável de ambiente</div>
    <img src="img/093.png" alt="Terminal mostrando o servidor rodando e a requisição chegando sem erros de CORS">
  </div>

  <p>Com a API no ar e o CORS liberado, falta a última peça: a interface HTML. O que ela precisa fazer é capturar o que o usuário digitou, enviar para o servidor, esperar a resposta e exibir na tela. Para enviar dados de uma página web para um servidor, o JavaScript usa uma função chamada <code>fetch()</code>.</p>

  <p>O <code>fetch()</code> é uma função nativa do navegador que faz requisições HTTP. Chamamos <code>fetch(url, opcoes)</code> passando o endereço e as configurações. Mas tem um detalhe: a resposta não chega na hora. O servidor precisa de tempo para processar. Por isso usamos duas palavras do JavaScript: <code>async</code> e <code>await</code>. O <code>async</code> na frente da função avisa que ela vai fazer operações que levam tempo. O <code>await</code> é colocado na frente de cada operação que precisa esperar, fazendo o código pausar naquele ponto até a resposta chegar. Sem o <code>await</code>, o código tentaria ler a resposta antes de ela existir, e daria erro.</p>

  <p>Dentro do <code>fetch()</code>, dois detalhes merecem atenção. O primeiro é o cabeçalho <code>Content-Type: application/json</code>. Um cabeçalho HTTP é uma informação extra que acompanha a requisição, como uma etiqueta na caixa dizendo o que tem dentro. Esse cabeçalho específico avisa o servidor que os dados estão em formato JSON. O segundo é o <code>JSON.stringify()</code>. Lembra do <code>json.loads()</code> da Aula 5, que converte texto JSON em dicionário Python? O <code>JSON.stringify()</code> faz o caminho inverso, só que em JavaScript. Ele pega um objeto como <code>{texto: "oi"}</code> e converte em texto JSON pronto para enviar.</p>

  <p>Um cuidado importante: o botão de envio é desabilitado enquanto a requisição está em andamento. Isso evita que o usuário clique várias vezes seguidas e cause múltiplas chamadas ao servidor ao mesmo tempo.</p>

<div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">051_index.html</div>
    </div>
    <pre><span class="cm">&lt;!-- versão simplificada para entender a estrutura central --&gt;</span>
&lt;<span class="kw">script</span>&gt;
<span class="kw">const</span> <span class="vr">API_URL</span> <span class="op">=</span> <span class="st">"http://127.0.0.1:8000/chat"</span>;

<span class="kw">async function</span> <span class="fn">enviarMensagem</span>() {
    <span class="kw">const</span> <span class="vr">input</span> <span class="op">=</span> document.<span class="fn">getElementById</span>(<span class="st">"campo"</span>);
    <span class="kw">const</span> <span class="vr">botao</span> <span class="op">=</span> document.<span class="fn">getElementById</span>(<span class="st">"btn"</span>);
    <span class="kw">const</span> <span class="vr">texto</span> <span class="op">=</span> <span class="vr">input</span>.<span class="vr">value</span>.<span class="fn">trim</span>();

    <span class="kw">if</span> (!<span class="vr">texto</span>) <span class="kw">return</span>;

    <span class="cm">// bloqueia o botão enquanto aguarda resposta</span>
    <span class="vr">botao</span>.<span class="vr">disabled</span> <span class="op">=</span> <span class="kw">true</span>;
    <span class="vr">input</span>.<span class="vr">value</span> <span class="op">=</span> <span class="st">""</span>;

    <span class="fn">adicionarMensagem</span>(<span class="st">"user"</span>, <span class="vr">texto</span>);   <span class="cm">// exibe na tela</span>
    <span class="fn">mostrarDigitando</span>();                   <span class="cm">// animação "..."</span>

    <span class="kw">try</span> {
        <span class="kw">const</span> <span class="vr">resposta</span> <span class="op">=</span> <span class="kw">await</span> <span class="fn">fetch</span>(<span class="vr">API_URL</span>, {
            <span class="vr">method</span>: <span class="st">"POST"</span>,
            <span class="vr">headers</span>: { <span class="st">"Content-Type"</span>: <span class="st">"application/json"</span> },
            <span class="vr">body</span>: <span class="fn">JSON.stringify</span>({ <span class="vr">texto</span>: <span class="vr">texto</span> })
        });
        <span class="kw">const</span> <span class="vr">dados</span> <span class="op">=</span> <span class="kw">await</span> <span class="vr">resposta</span>.<span class="fn">json</span>();
        <span class="fn">removerDigitando</span>();
        <span class="fn">adicionarMensagem</span>(<span class="st">"bot"</span>, <span class="vr">dados</span>.<span class="vr">resposta</span>);
    } <span class="kw">catch</span> (<span class="vr">erro</span>) {
        <span class="fn">removerDigitando</span>();
        <span class="fn">adicionarMensagem</span>(<span class="st">"bot"</span>, <span class="st">"Não consegui conectar. O servidor está rodando?"</span>);
    } <span class="kw">finally</span> {
        <span class="cm">// libera o botão independente do resultado</span>
        <span class="vr">botao</span>.<span class="vr">disabled</span> <span class="op">=</span> <span class="kw">false</span>;
    }
}
&lt;/<span class="kw">script</span>&gt;</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>async function enviarMensagem()</td>
      <td><strong>Declara uma função assíncrona.</strong> A palavra <code>async</code> permite usar <code>await</code> dentro dela. Sem o <code>async</code>, o JavaScript não aceita o <code>await</code>.</td>
    </tr>
    <tr>
      <td>botao.disabled = true</td>
      <td><strong>Desabilita o botão enquanto aguarda.</strong> Impede cliques múltiplos. O botão só volta ao normal no bloco <code>finally</code>, que executa sempre, deu certo ou deu erro.</td>
    </tr>
    <tr>
      <td>await fetch(API_URL, {...})</td>
      <td><strong>Envia a requisição POST e espera a resposta.</strong> O <code>await</code> pausa aqui até o servidor devolver algo. O <code>JSON.stringify({texto: texto})</code> converte o objeto JavaScript em texto JSON para enviar no corpo.</td>
    </tr>
    <tr>
      <td>await resposta.json()</td>
      <td><strong>Converte a resposta de JSON para objeto JavaScript.</strong> O servidor devolveu <code>{"resposta": "..."}</code> e esse <code>.json()</code> transforma em algo que o código acessa com <code>dados.resposta</code>.</td>
    </tr>
    <tr>
      <td>catch (erro) / finally</td>
      <td><strong>Trata erros e garante o botão liberado.</strong> O <code>catch</code> captura problemas de conexão, como o servidor estar parado. O <code>finally</code> roda sempre no final, garantindo que o botão volte ao normal.</td>
    </tr>
  </table>

  <p>O arquivo completo do exercício 051 está na seção de downloads, com a interface visual pronta: animação de digitação, alternância de tema claro e escuro, e histórico visual de mensagens. Para testar, deixe o <code>050_main.py</code> rodando num terminal e abra o <code>051_index.html</code> no navegador.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Exercício 051 - interface HTML conectada ao back-end</div>
    <img src="img/094.png" alt="Interface web do chatbot no navegador com histórico de mensagens">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Exercício 051 - memória persistindo entre recarregamentos da página</div>
    <img src="img/095.png" alt="Chatbot lembrando o nome do usuário após a página ser recarregada">
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Mas isso só funciona no meu computador, né? Como mando para alguém usar?</div>
  </div>

  <p>Por enquanto, sim. O endereço <code>127.0.0.1</code> significa "este computador", então só você consegue acessar. Para que outras pessoas usem, o código precisa estar num servidor com endereço público. Esse processo se chama <strong>deploy</strong>. Existem plataformas como o <strong>Railway</strong> (railway.com) e o <strong>Render</strong> que facilitam muito: você envia o código, configura a variável de ambiente com a chave, e elas cuidam do servidor. Vamos explorar o deploy numa aula futura.</p>

  <p>Outra coisa importante: não é só o navegador que consegue falar com a nossa API. Qualquer script Python também pode, usando a biblioteca <strong>requests</strong>. Instale com <code>pip install requests</code>. Com <code>requests.post(url, json=dados)</code> você envia uma requisição POST, e o parâmetro <code>json=</code> já converte o dicionário para JSON automaticamente. A resposta tem <code>.status_code</code> com o número de status e <code>.json()</code> para ler o corpo como dicionário Python. O exercício 053 explora exatamente isso.</p>

  <p>Uma última observação antes dos exercícios. Em produção, chatbots precisam de encerramento automático de sessão por inatividade. Se um usuário foi embora e voltou uma hora depois, o chatbot não pode continuar como se a conversa nunca tivesse parado. Em sistemas reais, um timeout de 15 a 30 minutos é o padrão. Nós não vamos implementar isso agora, mas é bom saber que existe.</p>

  <p>Agora é a sua vez.</p>

  <!-- EXERCÍCIO 052 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 052 - chatbot temático via API</span>
    <h3>Crie um back-end FastAPI para um tema à sua escolha <span class="ex-diff diff-1">iniciante</span></h3>
    <ol>
      <li>Crie um arquivo <code>052_main.py</code> do zero com um chatbot FastAPI para um tema de sua preferência, como suporte técnico, consultoria culinária ou recepção de hotel</li>
      <li>Defina um system prompt com Contexto, Tarefa, Formato e Restrições</li>
      <li>Implemente <code>@app.get("/")</code> e <code>@app.post("/chat")</code></li>
      <li>Proteja a chamada à IA com <code>try/except</code></li>
      <li>Inclua o CORS e leia a chave via <code>os.getenv()</code></li>
      <li>Teste pelo <code>/docs</code> antes de conectar qualquer interface</li>
    </ol>
    <p style="font-size:.85rem;color:var(--text3);margin:10px 0 0;font-style:italic;">💡 Dica: o exercício 050 tem uma boa base para começar.</p>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:12px 0 8px;display:block">// exemplo: chatbot de suporte de TI</span>
<div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">052_main.py</div>
          </div>
          <pre><span class="kw">import</span> warnings
<span class="kw">import</span> urllib3
<span class="kw">import</span> httpx
<span class="kw">import</span> os
<span class="kw">from</span> fastapi <span class="kw">import</span> FastAPI
<span class="kw">from</span> fastapi.middleware.cors <span class="kw">import</span> CORSMiddleware
<span class="kw">from</span> pydantic <span class="kw">import</span> BaseModel
<span class="kw">from</span> openai <span class="kw">import</span> OpenAI
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv

warnings.<span class="fn">filterwarnings</span>(<span class="st">"ignore"</span>)
urllib3.<span class="fn">disable_warnings</span>()
<span class="fn">load_dotenv</span>()

<span class="vr">app</span> <span class="op">=</span> <span class="fn">FastAPI</span>()
<span class="vr">app</span>.<span class="fn">add_middleware</span>(
    <span class="fn">CORSMiddleware</span>,
    <span class="vr">allow_origins</span><span class="op">=</span>[<span class="st">"*"</span>],
    <span class="vr">allow_methods</span><span class="op">=</span>[<span class="st">"*"</span>],
    <span class="vr">allow_headers</span><span class="op">=</span>[<span class="st">"*"</span>],
)

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="vr">SYSTEM_PROMPT</span> <span class="op">=</span> (
    <span class="st">"Contexto: você é o assistente de suporte de TI da empresa TechNova. "</span>
    <span class="st">"Tarefa: ajude os funcionários a resolver problemas técnicos comuns, "</span>
    <span class="st">"como conexão de rede, instalação de software e acesso a sistemas. "</span>
    <span class="st">"Formato: respostas curtas, em no máximo 3 frases, com passos numerados quando necessário. "</span>
    <span class="st">"Restrições: não acesse sistemas externos, não forneça credenciais, "</span>
    <span class="st">"e se não souber a resposta, diga claramente e oriente a abrir um chamado."</span>
)

<span class="vr">mensagens</span> <span class="op">=</span> [{<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="vr">SYSTEM_PROMPT</span>}]

<span class="kw">class</span> <span class="fn">Pergunta</span>(<span class="fn">BaseModel</span>):
    <span class="vr">texto</span>: <span class="bi">str</span>

<span class="dc">@app.get</span>(<span class="st">"/"</span>)
<span class="kw">def</span> <span class="fn">raiz</span>():
    <span class="kw">return</span> {<span class="st">"mensagem"</span>: <span class="st">"Suporte TechNova no ar!"</span>}

<span class="dc">@app.post</span>(<span class="st">"/chat"</span>)
<span class="kw">def</span> <span class="fn">chat</span>(<span class="vr">pergunta</span>: <span class="fn">Pergunta</span>):
    <span class="kw">global</span> <span class="vr">mensagens</span>
    <span class="vr">texto_usuario</span> <span class="op">=</span> <span class="vr">pergunta</span>.<span class="vr">texto</span>.<span class="fn">strip</span>()
    <span class="kw">if not</span> <span class="vr">texto_usuario</span>:
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">""</span>}

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">texto_usuario</span>})

    <span class="kw">try</span>:
        <span class="vr">resp</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4.1-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">120</span>,
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.2</span>
        )
        <span class="vr">texto</span> <span class="op">=</span> <span class="vr">resp</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>
    <span class="kw">except</span> <span class="fn">Exception</span>:
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Serviço temporariamente indisponível. Tente novamente em instantes."</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]

    <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="vr">texto</span>}</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 053 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 053 - cliente Python que fala com a API</span>
    <h3>Escreva um cliente.py que conversa com seu back-end via requests <span class="ex-diff diff-2">intermediário</span></h3>
    <ol>
      <li>Crie o arquivo <code>053_cliente.py</code> do zero</li>
      <li>Instale a biblioteca <code>requests</code> com <code>pip install requests</code></li>
      <li>Implemente um loop <code>while True</code> com <code>input()</code> onde o usuário digita e o código envia via <code>requests.post()</code> para <code>http://127.0.0.1:8000/chat</code></li>
      <li>O corpo da requisição deve ser <code>{"texto": mensagem}</code> usando o parâmetro <code>json=</code></li>
      <li>Leia a resposta com <code>resposta.json()["resposta"]</code></li>
      <li>Trate erros de conexão com <code>try/except</code></li>
      <li>Rode junto com o servidor do exercício 052 e verifique que funciona</li>
    </ol>
    <p style="font-size:.85rem;color:var(--text3);margin:10px 0 0;font-style:italic;">💡 Dica: o parâmetro <code>json=</code> do <code>requests.post()</code> já faz a conversão para JSON, sem precisar chamar nada extra.</p>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
<div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">053_cliente.py</div>
          </div>
          <pre><span class="kw">import</span> requests

<span class="vr">URL</span> <span class="op">=</span> <span class="st">"http://127.0.0.1:8000/chat"</span>

<span class="fn">print</span>(<span class="st">"Cliente conectado. Digite 'sair' para encerrar.\n"</span>)

<span class="kw">while</span> <span class="kw">True</span>:
    <span class="vr">mensagem</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Você: "</span>).<span class="fn">strip</span>()
    <span class="kw">if</span> <span class="vr">mensagem</span>.<span class="fn">lower</span>() <span class="op">==</span> <span class="st">"sair"</span>:
        <span class="fn">print</span>(<span class="st">"Encerrando."</span>)
        <span class="kw">break</span>
    <span class="kw">if not</span> <span class="vr">mensagem</span>:
        <span class="kw">continue</span>

    <span class="kw">try</span>:
        <span class="vr">resp</span> <span class="op">=</span> requests.<span class="fn">post</span>(<span class="vr">URL</span>, <span class="vr">json</span><span class="op">=</span>{<span class="st">"texto"</span>: <span class="vr">mensagem</span>})
        <span class="kw">if</span> <span class="vr">resp</span>.<span class="vr">status_code</span> <span class="op">==</span> <span class="nm">200</span>:
            <span class="fn">print</span>(<span class="st">"Bot:"</span>, <span class="vr">resp</span>.<span class="fn">json</span>()[<span class="st">"resposta"</span>], <span class="st">"\n"</span>)
        <span class="kw">else</span>:
            <span class="fn">print</span>(<span class="st">f"Erro {resp.status_code}: {resp.text}\n"</span>)
    <span class="kw">except</span> requests.<span class="vr">exceptions</span>.<span class="fn">ConnectionError</span>:
        <span class="fn">print</span>(<span class="st">"Não foi possível conectar. O servidor está rodando?\n"</span>)</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- EXERCÍCIO 054 -->
  <div class="exercise">
    <span class="ex-tag">⚡ exercício 054 - chatbot completo do zero ao produto</span>
    <h3>Sistema de ponta a ponta reunindo tudo do curso <span class="ex-diff diff-3">avançado</span></h3>
    <p style="font-size:.88rem;color:var(--text2);margin:0 0 14px;line-height:1.75;">Este exercício reúne os conceitos de todas as aulas do curso num único sistema funcional.</p>
    <ol>
      <li>Crie os arquivos <code>054_main.py</code> e <code>054_index.html</code> do zero, para um tema à sua escolha</li>
      <li><strong>Aulas 00 e 01</strong> - use funções <code>def</code> com responsabilidade única, inclua detecção direta de palavras-chave com <code>in</code> e <code>.lower()</code> para pelo menos dois padrões sem acionar a IA, como "oi", "tchau" ou "ajuda"</li>
      <li><strong>Aula 02 e Revisão</strong> - implemente <code>normalizar()</code> com NFD e use em todas as comparações de texto</li>
      <li><strong>Aula 03</strong> - conecte à API da OpenAI com histórico de mensagens usando as três roles: <code>system</code>, <code>user</code> e <code>assistant</code></li>
      <li><strong>Aula 04</strong> - monte um system prompt com Contexto, Tarefa, Formato e Restrições; configure <code>temperature</code> e <code>max_tokens</code> para o tema escolhido</li>
      <li><strong>Aula 05</strong> - para pelo menos um tipo de pergunta, instrua a IA a responder em JSON estruturado, receba com <code>json.loads()</code> e extraia um campo</li>
      <li><strong>Aula 06</strong> - guarde nome e uma informação extra em variáveis globais Python; atualize o system prompt dinamicamente com <code>if/elif/else</code>; deduplicação com <code>normalizar()</code></li>
      <li><strong>Aula 07</strong> - FastAPI com <code>@app.post("/chat")</code>, CORSMiddleware, chave via <code>os.getenv()</code>, e HTML com <code>fetch()</code>, <code>async/await</code>, botão travado e erro amigável</li>
      <li>Proteja toda chamada à IA com <code>try/except</code>, nunca mostrando erro de sistema ao usuário</li>
    </ol>
    <p style="font-size:.85rem;color:var(--text3);margin:10px 0 0;font-style:italic;">💡 Dica: vale construir tudo do zero consultando os exercícios anteriores como referência, para que cada parte fique bem fixada.</p>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:12px 0 8px;display:block">// exemplo: chatbot de livraria especializada</span>
<div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">054_main.py</div>
          </div>
          <pre><span class="kw">import</span> warnings, urllib3, unicodedata, httpx, os, json
<span class="kw">from</span> fastapi <span class="kw">import</span> FastAPI                                <span class="cm"># Aula 7</span>
<span class="kw">from</span> fastapi.middleware.cors <span class="kw">import</span> CORSMiddleware        <span class="cm"># Aula 7</span>
<span class="kw">from</span> pydantic <span class="kw">import</span> BaseModel                           <span class="cm"># Aula 7</span>
<span class="kw">from</span> openai <span class="kw">import</span> OpenAI                                <span class="cm"># Aula 3</span>
<span class="kw">from</span> dotenv <span class="kw">import</span> load_dotenv                           <span class="cm"># Aula 3</span>

warnings.<span class="fn">filterwarnings</span>(<span class="st">"ignore"</span>)
urllib3.<span class="fn">disable_warnings</span>()
<span class="fn">load_dotenv</span>()

<span class="vr">app</span> <span class="op">=</span> <span class="fn">FastAPI</span>()
<span class="vr">app</span>.<span class="fn">add_middleware</span>(<span class="fn">CORSMiddleware</span>, <span class="vr">allow_origins</span><span class="op">=</span>[<span class="st">"*"</span>], <span class="vr">allow_methods</span><span class="op">=</span>[<span class="st">"*"</span>], <span class="vr">allow_headers</span><span class="op">=</span>[<span class="st">"*"</span>])

<span class="vr">client</span> <span class="op">=</span> <span class="fn">OpenAI</span>(
    <span class="vr">api_key</span><span class="op">=</span>os.<span class="fn">getenv</span>(<span class="st">"OPENAI_API_KEY"</span>),               <span class="cm"># Aula 7 - variável de ambiente</span>
    <span class="vr">http_client</span><span class="op">=</span>httpx.<span class="fn">Client</span>(<span class="vr">verify</span><span class="op">=</span><span class="kw">False</span>)
)

<span class="cm"># Aula 6 - perfil em variáveis Python, não no histórico</span>
<span class="vr">perfil</span>: <span class="bi">dict</span> <span class="op">=</span> {<span class="st">"nome"</span>: <span class="kw">None</span>, <span class="st">"generos"</span>: []}
<span class="vr">mensagens</span>: <span class="bi">list</span> <span class="op">=</span> [{<span class="st">"role"</span>: <span class="st">"system"</span>, <span class="st">"content"</span>: <span class="st">""</span>}]  <span class="cm"># Aula 3 - roles</span>

<span class="cm"># Aula 2 + Revisão - normalizar com NFD</span>
<span class="kw">def</span> <span class="fn">normalizar</span>(<span class="vr">texto</span>: <span class="bi">str</span>) <span class="op">-></span> <span class="bi">str</span>:
    <span class="vr">texto</span> <span class="op">=</span> <span class="vr">texto</span>.<span class="fn">lower</span>()
    <span class="vr">texto</span> <span class="op">=</span> unicodedata.<span class="fn">normalize</span>(<span class="st">"NFD"</span>, <span class="vr">texto</span>)
    <span class="vr">texto</span> <span class="op">=</span> <span class="st">""</span>.<span class="fn">join</span>(<span class="vr">c</span> <span class="kw">for</span> <span class="vr">c</span> <span class="kw">in</span> <span class="vr">texto</span> <span class="kw">if</span> unicodedata.<span class="fn">category</span>(<span class="vr">c</span>) <span class="op">!=</span> <span class="st">"Mn"</span>)
    <span class="kw">return</span> <span class="vr">texto</span>

<span class="cm"># Aula 6 - system prompt dinâmico com if/elif/else</span>
<span class="kw">def</span> <span class="fn">atualizar_system</span>() <span class="op">-></span> <span class="kw">None</span>:
    <span class="cm"># Aula 4 - Contexto, Tarefa, Formato, Restrições</span>
    <span class="vr">ctx</span> <span class="op">=</span> <span class="st">"Contexto: você é o assistente virtual da Livraria Leitura Viva, especializada em literatura brasileira. "</span>
    <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"nome"</span>] <span class="kw">and</span> <span class="vr">perfil</span>[<span class="st">"generos"</span>]:
        <span class="vr">gs</span> <span class="op">=</span> <span class="st">", "</span>.<span class="fn">join</span>(<span class="vr">perfil</span>[<span class="st">"generos"</span>])
        <span class="vr">tarefa</span> <span class="op">=</span> <span class="st">f"Atenda {perfil['nome']} que gosta de: {gs}. Personalize as sugestões."</span>
    <span class="kw">elif</span> <span class="vr">perfil</span>[<span class="st">"nome"</span>]:
        <span class="vr">tarefa</span> <span class="op">=</span> <span class="st">f"Atenda {perfil['nome']} com cordialidade."</span>
    <span class="kw">else</span>:
        <span class="vr">tarefa</span> <span class="op">=</span> <span class="st">"Acolha o cliente com simpatia e pergunte o que procura."</span>
    <span class="vr">fmt</span> <span class="op">=</span> (
        <span class="st">"Formato: respostas em até 3 frases. Quando indicar livros, responda APENAS em JSON "  </span>
        <span class="st">"no formato {'titulo': str, 'autor': str, 'motivo': str}. Sem texto fora do JSON. "</span>
        <span class="st">"Restrições: fale apenas sobre livros e a livraria. Nunca invente ISBNs ou prêmios."</span>
    )
    <span class="vr">mensagens</span>[<span class="nm">0</span>][<span class="st">"content"</span>] <span class="op">=</span> <span class="vr">ctx</span> <span class="op">+</span> <span class="vr">tarefa</span> <span class="op">+</span> <span class="vr">fmt</span>

<span class="fn">atualizar_system</span>()

<span class="cm"># Aula 1 - respostas diretas por palavra-chave, sem acionar IA</span>
<span class="kw">def</span> <span class="fn">resposta_direta</span>(<span class="vr">texto_norm</span>: <span class="bi">str</span>) <span class="op">-></span> <span class="bi">str</span> <span class="op">|</span> <span class="kw">None</span>:
    <span class="kw">if</span> <span class="st">"oi"</span> <span class="kw">in</span> <span class="vr">texto_norm</span> <span class="kw">or</span> <span class="st">"ola"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">nome</span> <span class="op">=</span> <span class="st">f", {perfil['nome']}"</span> <span class="kw">if</span> <span class="vr">perfil</span>[<span class="st">"nome"</span>] <span class="kw">else</span> <span class="st">""</span>
        <span class="kw">return</span> <span class="st">f"Olá{nome}! Bem-vindo à Leitura Viva. Posso indicar um livro ou tirar dúvidas."</span>
    <span class="kw">if</span> <span class="st">"tchau"</span> <span class="kw">in</span> <span class="vr">texto_norm</span> <span class="kw">or</span> <span class="st">"ate logo"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="kw">return</span> <span class="st">"Até a próxima! Boas leituras."</span>
    <span class="kw">if</span> <span class="st">"ajuda"</span> <span class="kw">in</span> <span class="vr">texto_norm</span> <span class="kw">or</span> <span class="st">"o que voce faz"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="kw">return</span> <span class="st">"Posso indicar livros, responder sobre o acervo e ajudar com sugestões por gênero."</span>
    <span class="kw">return</span> <span class="kw">None</span>

<span class="kw">class</span> <span class="fn">Pergunta</span>(<span class="fn">BaseModel</span>):
    <span class="vr">texto</span>: <span class="bi">str</span>

<span class="dc">@app.get</span>(<span class="st">"/"</span>)
<span class="kw">def</span> <span class="fn">raiz</span>():
    <span class="kw">return</span> {<span class="st">"mensagem"</span>: <span class="st">"Leitura Viva no ar!"</span>}

<span class="dc">@app.post</span>(<span class="st">"/chat"</span>)
<span class="kw">def</span> <span class="fn">chat</span>(<span class="vr">pergunta</span>: <span class="fn">Pergunta</span>):
    <span class="kw">global</span> <span class="vr">perfil</span>, <span class="vr">mensagens</span>
    <span class="vr">texto_usuario</span> <span class="op">=</span> <span class="vr">pergunta</span>.<span class="vr">texto</span>.<span class="fn">strip</span>()
    <span class="vr">texto_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">texto_usuario</span>)

    <span class="kw">if not</span> <span class="vr">texto_usuario</span>:
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">""</span>}

    <span class="cm"># Aula 1 - palavras-chave diretas antes da IA</span>
    <span class="vr">dr</span> <span class="op">=</span> <span class="fn">resposta_direta</span>(<span class="vr">texto_norm</span>)
    <span class="kw">if</span> <span class="vr">dr</span>:
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="vr">dr</span>}

    <span class="cm"># Aula 6 - captura de nome</span>
    <span class="kw">if</span> <span class="st">"meu nome e"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">nome</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">split</span>(<span class="st">"meu nome é"</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>().<span class="fn">title</span>()
        <span class="vr">perfil</span>[<span class="st">"nome"</span>] <span class="op">=</span> <span class="vr">nome</span>
        <span class="fn">atualizar_system</span>()
        <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Prazer, {nome}! Qual tipo de leitura você curte?"</span>}

    <span class="cm"># Aula 6 - captura de gênero literário com deduplicação</span>
    <span class="kw">if</span> <span class="st">"gosto de"</span> <span class="kw">in</span> <span class="vr">texto_norm</span> <span class="kw">or</span> <span class="st">"curto"</span> <span class="kw">in</span> <span class="vr">texto_norm</span>:
        <span class="vr">divisor</span> <span class="op">=</span> <span class="st">"gosto de"</span> <span class="kw">if</span> <span class="st">"gosto de"</span> <span class="kw">in</span> <span class="vr">texto_usuario</span>.<span class="fn">lower</span>() <span class="kw">else</span> <span class="st">"curto"</span>
        <span class="vr">genero</span> <span class="op">=</span> <span class="vr">texto_usuario</span>.<span class="fn">lower</span>().<span class="fn">split</span>(<span class="vr">divisor</span>)[<span class="op">-</span><span class="nm">1</span>].<span class="fn">strip</span>()
        <span class="vr">genero_norm</span> <span class="op">=</span> <span class="fn">normalizar</span>(<span class="vr">genero</span>)
        <span class="kw">if</span> <span class="vr">genero_norm</span> <span class="kw">not in</span> [<span class="fn">normalizar</span>(<span class="vr">g</span>) <span class="kw">for</span> <span class="vr">g</span> <span class="kw">in</span> <span class="vr">perfil</span>[<span class="st">"generos"</span>]]:
            <span class="vr">perfil</span>[<span class="st">"generos"</span>].<span class="fn">append</span>(<span class="vr">genero</span>)
            <span class="fn">atualizar_system</span>()
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Anotei que você curte {genero}. Posso indicar algo nessa linha!"</span>}
        <span class="kw">else</span>:
            <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="st">f"Já sei que você curte {genero}!"</span>}

    <span class="cm"># Aula 3 - histórico acumulado</span>
    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"user"</span>, <span class="st">"content"</span>: <span class="vr">texto_usuario</span>})

    <span class="kw">try</span>:  <span class="cm"># Aula 4 - try/except que protege o usuário</span>
        <span class="vr">resp</span> <span class="op">=</span> <span class="vr">client</span>.<span class="vr">chat</span>.<span class="vr">completions</span>.<span class="fn">create</span>(
            <span class="vr">model</span><span class="op">=</span><span class="st">"gpt-4.1-mini"</span>,
            <span class="vr">messages</span><span class="op">=</span><span class="vr">mensagens</span>,
            <span class="vr">max_tokens</span><span class="op">=</span><span class="nm">120</span>,     <span class="cm"># Aula 4</span>
            <span class="vr">temperature</span><span class="op">=</span><span class="nm">0.4</span>     <span class="cm"># Aula 4 - equilíbrio entre criatividade e precisão</span>
        )
        <span class="vr">raw</span> <span class="op">=</span> <span class="vr">resp</span>.<span class="vr">choices</span>[<span class="nm">0</span>].<span class="vr">message</span>.<span class="vr">content</span>.<span class="fn">strip</span>()

        <span class="cm"># Aula 5 - tenta interpretar como JSON se a IA devolveu um livro</span>
        <span class="kw">try</span>:
            <span class="vr">dados</span> <span class="op">=</span> json.<span class="fn">loads</span>(<span class="vr">raw</span>)
            <span class="vr">texto</span> <span class="op">=</span> <span class="st">f"Sugestão: <strong>{dados['titulo']}</strong> de {dados['autor']}. {dados['motivo']}"</span>
        <span class="kw">except</span> (<span class="fn">json.JSONDecodeError</span>, <span class="fn">KeyError</span>):
            <span class="vr">texto</span> <span class="op">=</span> <span class="vr">raw</span>  <span class="cm"># resposta normal em texto</span>

    <span class="kw">except</span> <span class="fn">Exception</span>:
        <span class="vr">texto</span> <span class="op">=</span> <span class="st">"Desculpe, tive um problema. Pode repetir a pergunta?"</span>  <span class="cm"># Aula 6 - nunca expor erro</span>

    <span class="vr">mensagens</span>.<span class="fn">append</span>({<span class="st">"role"</span>: <span class="st">"assistant"</span>, <span class="st">"content"</span>: <span class="vr">texto</span>})
    <span class="cm"># Aula 3 - controle do histórico para não crescer demais</span>
    <span class="kw">if</span> <span class="fn">len</span>(<span class="vr">mensagens</span>) <span class="op">></span> <span class="nm">10</span>:
        <span class="vr">mensagens</span> <span class="op">=</span> [<span class="vr">mensagens</span>[<span class="nm">0</span>]] <span class="op">+</span> <span class="vr">mensagens</span>[<span class="op">-</span><span class="nm">9</span>:]

    <span class="kw">return</span> {<span class="st">"resposta"</span>: <span class="vr">texto</span>}</pre>
        </div>
        <span style="font-family:'Fira Code',monospace;font-size:9.5px;letter-spacing:.15em;color:var(--green);text-transform:uppercase;margin:20px 0 8px;display:block">// 054_index.html - partes essenciais do front-end</span>
<div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">054_index.html (trecho do script)</div>
          </div>
          <pre><span class="cm">// Aula 7 - fetch com async/await, botão travado, erro amigável</span>
<span class="kw">const</span> <span class="vr">API_URL</span> <span class="op">=</span> <span class="st">"http://127.0.0.1:8000/chat"</span>;

<span class="kw">async function</span> <span class="fn">enviar</span>() {
    <span class="kw">const</span> <span class="vr">campo</span> <span class="op">=</span> document.<span class="fn">getElementById</span>(<span class="st">"campo"</span>);
    <span class="kw">const</span> <span class="vr">botao</span> <span class="op">=</span> document.<span class="fn">getElementById</span>(<span class="st">"btn"</span>);
    <span class="kw">const</span> <span class="vr">texto</span> <span class="op">=</span> <span class="vr">campo</span>.<span class="vr">value</span>.<span class="fn">trim</span>();
    <span class="kw">if</span> (!<span class="vr">texto</span>) <span class="kw">return</span>;

    <span class="vr">botao</span>.<span class="vr">disabled</span> <span class="op">=</span> <span class="kw">true</span>;
    <span class="vr">campo</span>.<span class="vr">value</span> <span class="op">=</span> <span class="st">""</span>;
    <span class="fn">adicionarMsg</span>(<span class="st">"user"</span>, <span class="vr">texto</span>);

    <span class="kw">try</span> {
        <span class="kw">const</span> <span class="vr">r</span> <span class="op">=</span> <span class="kw">await</span> <span class="fn">fetch</span>(<span class="vr">API_URL</span>, {
            <span class="vr">method</span>: <span class="st">"POST"</span>,
            <span class="vr">headers</span>: { <span class="st">"Content-Type"</span>: <span class="st">"application/json"</span> },
            <span class="cm">// JSON.stringify: inverso do json.loads() - objeto JS → string JSON</span>
            <span class="vr">body</span>: <span class="fn">JSON.stringify</span>({ <span class="vr">texto</span>: <span class="vr">texto</span> })
        });
        <span class="kw">const</span> <span class="vr">dados</span> <span class="op">=</span> <span class="kw">await</span> <span class="vr">r</span>.<span class="fn">json</span>();
        <span class="fn">adicionarMsg</span>(<span class="st">"bot"</span>, <span class="vr">dados</span>.<span class="vr">resposta</span>);
    } <span class="kw">catch</span> {
        <span class="fn">adicionarMsg</span>(<span class="st">"bot"</span>, <span class="st">"Não consegui conectar. O servidor está rodando?"</span>);
    } <span class="kw">finally</span> {
        <span class="vr">botao</span>.<span class="vr">disabled</span> <span class="op">=</span> <span class="kw">false</span>;
    }
}</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- DOWNLOADS -->
  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">

      <a class="dl-item" href="arquivos/049_main.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">049_main.py</div>
          <div class="dl-desc">Primeiro back-end FastAPI com endpoint /chat e memória em variáveis globais</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/050_main.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">050_main.py</div>
          <div class="dl-desc">FastAPI com CORS, variável de ambiente e load_dotenv</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/051_index.html" target="_blank">
        <span class="dl-icon">🌐</span>
        <div class="dl-info">
          <div class="dl-name">051_index.html</div>
          <div class="dl-desc">Interface web com fetch(), animação de digitação e botão travado</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/052_main.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">052_main.py</div>
          <div class="dl-desc">Exercício 52 - chatbot temático com system prompt estruturado</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/053_cliente.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">053_cliente.py</div>
          <div class="dl-desc">Exercício 53 - cliente Python que conversa com a API via requests</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/054_main.py" target="_blank">
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">054_main.py</div>
          <div class="dl-desc">Exercício 54 - back-end completo reunindo todas as aulas</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/054_index.html" target="_blank">
        <span class="dl-icon">🌐</span>
        <div class="dl-info">
          <div class="dl-name">054_index.html</div>
          <div class="dl-desc">Exercício 54 - interface HTML conectada ao back-end</div>
        </div>
        <span class="dl-badge">↗ visualizar</span>
      </a>

    </div>
  </div>

  <div class="ready">
    <span class="re">🎉</span>
    <h2>Isso é tudo por hoje!</h2>
    <p>Revise os exercícios, rode o servidor, abra o HTML e experimente. Na Aula 8, nós vamos avançar na separação de usuários para que o chatbot saiba com quem está falando.</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="aula6.php">← Aula 6</a>
    <a class="nav-link next" href="aula8.php">Aula 8 →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>

<footer>
  <span>Chatbots com Python · aula 7</span>
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
