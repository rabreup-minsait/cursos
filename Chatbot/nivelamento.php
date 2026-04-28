<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nivelamento - Chatbots com Python</title>
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
.cover { margin-bottom: 52px; padding-bottom: 0; }
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

/* ── SECTION BREAK - separador discreto entre grandes blocos ── */
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

/* ── LOUSA - compacta, como uma anotação no quadro ── */
.lousa {
  background: var(--board);
  border-radius: 6px;
  padding: 14px 18px;
  margin: 22px auto;
  max-width: 480px;          /* não ocupa a coluna toda */
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

/* ── BALÃO DE ALUNO - destaque real ── */
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

/* ── CALLOUT de atenção - substitui os "asides" vagos ── */
/* Usado para: dica prática da professora no meio da explicação */
.dica {
  border-left: 3px solid var(--accent);
  background: var(--accent-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #1a3a6a; line-height: 1.75;
}
.dica strong { color: #1a3a6a; font-weight: 800; }

/* Usado para: atenção / cuidado / passo crítico */
.atencao {
  border-left: 3px solid var(--gold);
  background: var(--gold-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #5a3808; line-height: 1.75;
}
.atencao strong { color: #5a3808; font-weight: 800; }

/* Usado para: aviso de erro comum */
.aviso {
  border-left: 3px solid var(--red);
  background: var(--red-lt);
  border-radius: 0 7px 7px 0;
  padding: 12px 16px; margin: 20px 0;
  font-size: .9rem; color: #6a1515; line-height: 1.75;
}
.aviso strong { color: #6a1515; font-weight: 800; }

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

/* ── TABELA DE ANOTAÇÃO DO CÓDIGO ── */
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

/* ── TIPO CARDS ── */
.type-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; margin:18px 0; }
.tcard { background:var(--surface); border:1px solid var(--border); border-radius:7px; padding:12px 10px; text-align:center; box-shadow:var(--shadow-sm); }
.tcard .tn { font-family:'Fira Code',monospace; font-size:.85rem; color:var(--accent); font-weight:500; margin-bottom:5px; }
.tcard .te { font-family:'Fira Code',monospace; font-size:.72rem; color:var(--green); margin-bottom:5px; line-height:1.9; }
.tcard .td { font-size:.72rem; color:var(--text3); }

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
.dl-icon {
  font-size: 1.1rem; flex-shrink: 0;
}
.dl-info { flex: 1; }
.dl-name {
  font-family: 'Fira Code', monospace; font-size: .78rem;
  color: var(--accent); font-weight: 500;
}
.dl-desc {
  font-size: .75rem; color: var(--text3); margin-top: 1px;
}
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
.nav-bottom { display:flex; justify-content:space-between; border-top:1px solid var(--border); padding-top:24px; margin-top:48px; }
.nav-link { display:inline-flex; align-items:center; gap:5px; font-size:.82rem; font-weight:700; color:var(--text3); text-decoration:none; padding:7px 14px; border:1px solid var(--border); border-radius:6px; background:var(--surface); transition:all .15s; }
.nav-link:hover { border-color:var(--accent); color:var(--accent); }
.nav-link.next { background:var(--accent); color:#fff; border-color:var(--accent); }
.nav-link.next:hover { background:#1a4f8a; }

/* ── FOOTER ── */
footer { border-top:1px solid var(--border); padding:10px 28px; display:flex; align-items:center; justify-content:space-between; font-family:'Fira Code',monospace; font-size:10px; color:var(--text3); background:var(--surface); }

/* ── RESPONSIVE ── */
@media(max-width:600px){
  .wrap { padding:28px 16px 60px; }
  .topbar { padding:0 16px; }
  .type-grid { grid-template-columns:repeat(2,1fr); }
  .flow { flex-direction:column; gap:4px; }
  .farrow { transform:rotate(90deg); }
  .tb-lesson { display:none; }
  .lousa { max-width:100%; }
}
</style>
</head>
<body>

<div class="prog" id="prog"></div>

<header class="topbar">
  <a class="tb-logo" href="AulaChatbot.html">
    <div class="tb-logo-icon">🐍</div>
    Chatbots com Python
  </a>
  <div class="tb-nav">
    <a class="tb-btn" href="AulaChatbot.html">⊞ índice</a>
    <span class="tb-lesson">aula 00 · nivelamento</span>
    <a class="tb-btn" href="AulaChatbot.html">←</a>
    <a class="tb-btn next" href="aula1.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <h1>Antes de começar: <br>vamos <em>nivelar</em> o conhecimento</h1>
    <p>Olá pessoal, tudo bem? Estão animados para criar chatbots? Eu estou! Antes de colocarmos a mão na massa, vamos conversar sobre algumas coisas importantes, não porque seja obrigatório, mas porque entender o <em>porquê</em> de tudo muda completamente a experiência de aprender.</p>
  <p>É muito comum me perguntarem: "Onde você programa? Precisa de algum programa especial?" Vou responder essas perguntas de um jeito que vai fazer sentido para vocês.</p>
  <p>Pensa no atendente virtual do seu banco. Sabe aquele que aparece quando você abre o aplicativo e pergunta "como posso te ajudar hoje"? Você digita "quero ver meu saldo", ele entende, vai buscar a informação e te responde. Parece simples, né? Mas por trás daquela janelinha de chat existe um mundo de coisas acontecendo. Tem um banco de dados com todas as informações da sua conta. Tem um código que recebe a sua mensagem, entende o que você quer, busca no banco de dados e monta a resposta. E tem a tela do aplicativo, que é só a "vitrine" de tudo isso.</p>

  <div class="lousa">
    <div class="lousa-title">por trás do atendente virtual do banco</div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Banco de dados</strong> - saldo, extrato, dados da conta</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Código</strong> - recebe sua mensagem, entende o que você quer e busca a resposta</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Interface</strong> - a janela de chat que você vê na tela</span></div>
  </div>

  <p>Programar é exatamente isso: <strong>escrever as instruções que fazem o computador fazer algo útil.</strong> Esse atendente virtual do banco é um chatbot, chatbot vem de "chat" (conversa) e "bot" (robô), é um programa que responde a perguntas e executa tarefas automaticamente, geralmente por texto ou voz. Você provavelmente já usou vários sem perceber: o atendente do banco, o assistente do site de passagens, a Alexa da Amazon. É exatamente esse tipo de programa que vamos aprender a construir aqui.</p>

  <p>Antes de continuar, preciso que você grave uma coisa: <strong>o computador não pensa.</strong> Sério. Ele não improvisa, não interpreta, não toma iniciativa. Ele executa exatamente o que você mandar, nem mais, nem menos. Parece óbvio quando eu falo assim, mas é a causa de 90% das frustrações de quem está começando.</p>

  <p>Olha esse exemplo. Para nós, abrir uma porta é um movimento automático, nem pensamos nisso. Mas para o computador, cada passo precisa ser descrito:</p>

  <div class="lousa">
    <div class="lousa-title">instrução para abrir uma porta</div>
    <div class="lousa-row"><span class="bul">→</span><span>Levantar da cadeira</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Andar até a porta</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Virar para a porta</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Pegar na maçaneta</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Girar a maçaneta</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Puxar a porta</span></div>
  </div>

  <p>Se eu esquecer de escrever "girar a maçaneta", o computador vai pegar na maçaneta e simplesmente parar. Não vai tentar girar por conta própria, não vai perguntar o que fazer, vai travar, esperando uma instrução que nunca veio. Isso é programar: <strong>descrever cada passo com precisão.</strong></p>

  <p>E essa sequência de passos ordenados para resolver um problema tem um nome: <strong>algoritmo</strong>. Toda vez que você escreve um código, você está criando um algoritmo. Não precisa ser complicado, a lista de passos para abrir a porta é um algoritmo. A receita de um bolo é um algoritmo. O que importa é que os passos estejam na ordem certa, sejam claros e levem ao resultado esperado.</p>

  <div class="lousa">
    <div class="lousa-title">algoritmo: as três características</div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Sequência</strong> - os passos têm ordem. Pegar na maçaneta antes de girar não funciona da mesma forma que girar antes de pegar.</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Clareza</strong> - cada instrução precisa ser precisa, sem ambiguidade. "Abra a porta" não serve, o computador não sabe o que é "abrir".</span></div>
    <div class="lousa-row"><span class="bul">◆</span><span><strong>Resultado</strong> - todo algoritmo tem um objetivo claro. No nosso caso: porta aberta.</span></div>
  </div>

  <p>Quando você escreve <code>def cumprimento():</code> mais à frente, você está criando um algoritmo chamado "cumprimento". Cada linha dentro dele é um passo. O Python vai executar na ordem, um por um, exatamente como você escreveu. Guarda isso.</p>

  <p>Quando o código não funcionar como você esperava, a primeira pergunta que você deve se fazer é: <em>"eu dei instrução suficiente?"</em>. Na maior parte dos casos, a resposta é não, e faz parte, acontece com todo mundo, inclusive com quem programa há anos.</p>

  <p>Com esse conceito de algoritmo na cabeça, você já entende o que é programar. Mas onde esse código vive? É aí que entram dois termos que você vai ouvir muito: front-end e back-end. Vou simplificar de uma vez. Pensa num restaurante. Você senta, vê o cardápio, faz o pedido, come, tudo isso é o <strong>front-end</strong>, a "frente", o que o cliente vê e vive. Lá na cozinha, o chef prepara, os ingredientes estão organizados, o sistema de pedidos funciona, isso é o <strong>back-end</strong>, o que acontece por trás, invisível para quem está na mesa. Voltando ao nosso atendente virtual do banco: a janelinha de chat que você vê é o front-end. O código que entende sua mensagem, busca seu saldo e monta a resposta, esse é o back-end. É no back-end que o chatbot vive, onde a lógica acontece. E é lá que vamos trabalhar.</p>

  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Mas o front-end não é só design? Só deixar as coisas bonitinhas?</div>
  </div>

  <p>Não, de jeito nenhum! Essa é uma ideia errada que circula bastante. O front-end também tem código, lógica e regras: validar se o e-mail está correto antes de enviar, bloquear um botão enquanto o sistema processa, limitar quantos caracteres cabem num campo. Não subestime quem trabalha lá!</p>

  <p>Existem muitas linguagens de programação: JavaScript, Java, PHP, C++, Ruby, Go... Assim como existem o português, o inglês e o espanhol. Cada uma tem seus usos e suas situações ideais. Assim também é com as linguagens de programação, elas podem ser escritas em diversos editores, algumas até no Bloco de Notas. No nosso caso usaremos o <strong>VSCode</strong>, a linguagem será o Python, e já vou explicar o porquê.</p>

  <p>Utilizaremos o <strong>Python</strong> porque para chatbots e inteligência artificial, Python é hoje a linguagem mais usada no mundo, devido inclusive por suas principais bibliotecas de IA, incluindo a que usaremos para acessar o GPT, foram pensadas para Python primeiro. E além disso, Python é a linguagem mais próxima do inglês natural. Você consegue ler um código e entender o que está acontecendo mesmo sem nunca ter programado na vida :-). Isso torna o aprendizado muito mais rápido e muito menos frustrante.</p>

  <div class="dica">
    A lógica que você vai aprender aqui vale para qualquer linguagem. Quem aprende a pensar como programador em Python consegue migrar para Java, JavaScript ou qualquer outra com muito mais facilidade, o que muda é a sintaxe, não o raciocínio.
  </div>

  <p>E é com Python que vamos dar vida ao nosso chatbot. A Alexa é um ótimo exemplo de como todo chatbot funciona por dentro. Quando eu falo <em>"Alexa"</em>, esse é o <strong>input</strong> (a entrada), o meu pedido chegando até ela. Ela acende: esse é o primeiro <strong>output</strong>, sinalizando que está me ouvindo. Depois eu falo "que horas são?" (novo input). Ela vai buscar o horário numa API baseada na minha localização, esse é o <strong>processamento</strong>, onde ela pensa. E responde "<span id="hora-atual"></span>", o output final para mim.</p>

  <script>
    const _h = new Date();
    const _hh = String(_h.getHours()).padStart(2,'0');
    const _mm = String(_h.getMinutes()).padStart(2,'0');
    document.getElementById('hora-atual').textContent = 'são ' + _hh + ' e ' + _mm;
  </script>

  <div class="flow">
    <div class="fbox hi"><span class="fe">🎤</span><span class="fl"> input </span><span class="fn2">sua pergunta</span></div>
    <div class="farrow">→</div>
    <div class="fbox hi"><span class="fe">🧠</span><span class="fl"> processamento </span><span class="fn2">o bot decide</span></div>
    <div class="farrow">→</div>
    <div class="fbox hi"><span class="fe">💬</span><span class="fl"> output </span><span class="fn2">a resposta</span></div>
  </div>

  <p>Todo chatbot, do mais simples ao mais sofisticado com IA, segue esse ciclo. O que muda é o que acontece no meio, no processamento. E é exatamente isso que vamos construir juntos, passo a passo. Começaremos sem IA, só com código puro, para você entender o fluxo e ganhar confiança. Depois colocamos a inteligência artificial por cima. Não dá pra colocar o recheio antes de fazer a massa! :-)</p>

  <p>Falei no VSCode, mas você ainda não sabe o que é. Vamos resolver isso agora, porque antes de escrever qualquer código, a gente precisa ter as ferramentas instaladas. O <strong>Visual Studio Code</strong> é o editor que vamos usar. É gratuito, da Microsoft, e é um dos mais usados no mundo. Pense nele como um Bloco de Notas superpoderoso: coloca cores nas palavras do código, aponta erros enquanto você escreve e sugere completar automaticamente.</p>

  <p>Faremos duas instalações. A primeira é o próprio VSCode, o lugar onde você vai escrever o código. A segunda é o Python: o motor que vai <em>executar</em> o que você escrever. Pensa assim: O VSCode é o painel do carro,  onde você vê tudo e controla. O Python é o motor, a gente não vê com o carro em movimento, mas sem ele o carro não anda. Sem o Python instalado, o VSCode até abre o arquivo, mas não consegue rodar o código em Python.</p>

  <p>Vou mostrar o passo a passo com as telas reais, exatamente o que você vai ver na tela. Acesse <strong>https://code.visualstudio.com/download</strong> e clique no botão Windows:</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Clique em Windows para baixar o instalador</div>
    <img src="img/001.png" alt="Página de download do VSCode: botão Windows destacado">
    <div class="install-step-desc">O download começa automaticamente.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Acompanhe o download </div>
    <img src="img/002.png" alt="Download em andamento no Edge">
    <div class="install-step-desc">Aguarde terminar o download.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">3</div> Download Finalizado: Clique em "Abrir arquivo"</div>
    <img src="img/003.png" alt="Aviso de segurança do Windows - botão Executar">
    <div class="install-step-desc">Com o download finalizado, clique em <strong>"Abrir arquivo"</strong>.</div>
  </div>

  <div class="install-step">
     <div class="install-step-head"><div class="install-num">4</div> Clique em "Executar" na janela de aviso de segurança</div>
    <img src="img/004.png" alt="Tela de aviso de segurança">
    <div class="install-step-desc">O Windows pergunta se você quer executar. Clique em <strong>Executar</strong>. É seguro, é da Microsoft.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">5</div>Acordo de Licença: Selecione Eu aceito o acordo e clique em Avançar</div>
    <img src="img/005.png" alt="Acordo de Licença">
    <div class="install-step-desc">Selecione "Eu aceito o acordo" e clique em <strong>Avançar</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">6</div> Local de Instalação: Deixe como está.</div>
    <img src="img/006.png" alt="Tela de pasta do Local de Destino">
    <div class="install-step-desc">Não precisa mudar nada aqui. Clique em <strong> Avançar</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">7</div> Pasta do Menu Iniciar: Clique em Avançar</div>
    <img src="img/007.png" alt="Tela Pasta do Menu Iniciar">
    <div class="install-step-desc">Clique em <strong>Avançar</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">8</div> Tela de tarefas adicionais: Clique em avançar</div>
    <img src="img/008.png" alt="Tela de tarefas adicionais">
    <div class="install-step-desc">Clique em <strong>Avançar</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">9</div> Pronto para Instalar: clique em Instalar</div>
    <img src="img/009.png" alt="Pronto para Instalar">
    <div class="install-step-desc">Clique em <strong>Instalar</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">10</div> Processo de Instalação</div>
    <img src="img/010.png" alt="Barra de progresso da instalação do VSCode">
    <div class="install-step-desc">A barra de progresso avança sozinha. Leva cerca de 1 minuto. Não feche a janela.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">11</div> Instalação concluída</div>
    <img src="img/011.png" alt="Tela de Processo de Instalação">
    <div class="install-step-desc">A instalação terminou! Deixe marcada a opção <strong>"Abrir o Visual Studio Code"</strong> e clique em Concluir. O VSCode já vai abrir na sequência.</div>

  </div>

    <div class="install-step">
    <div class="install-step-head"><div class="install-num">12</div> VSCode aberto: Bem-vindo ao seu editor!</div>
    <img src="img/012.png" alt="VSCode aberto pela primeira vez">
    <div class="install-step-desc">Essa é a cara do VSCode, o nosso playground a partir de agora. A tela de boas-vindas aparece na primeira vez. Pode fechar essa aba, o importante está na barra lateral esquerda, onde vamos criar nossos arquivos Python.</div>
  </div>


  <p>Com o VSCode instalado, agora vamos instalar o Python. Lembra da analogia do carro, o VSCode é o painel, o Python é o motor. Sem o Python, o VSCode até abre o arquivo, mas não consegue rodar nada. Acesse <strong>https://www.python.org/downloads/</strong> e siga os passos:</p>

  <div class="atencao">
    <strong>Atenção:</strong> o Python é instalado de forma diferente do VSCode, ele abre um terminal. Não se assuste, é só seguir os passos abaixo.
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> Página do Python: Clique em "Download Python install manager"</div>
    <img src="img/013.png" alt="Site Python">
    <div class="install-step-desc">No site do Python, clique em <strong>Download Python install manager</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Download finalizado: Clique em "Abrir arquivo"</div>
    <img src="img/014.png" alt="Download finalizado">
    <div class="install-step-desc">Com o download finalizado, clique em <strong>Abrir arquivo</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">3</div> Install Python Install Manager</div>
    <img src="img/015.png" alt="Install Python">
    <div class="install-step-desc">Clique em <strong>Install Python</strong>.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">4</div> Tela de instalação 1</div>
    <img src="img/016.png" alt="Tela instalação 1">
    <div class="install-step-desc">Em <strong>"Update setting now? [y/N]"</strong>, digite <strong>Y</strong> e pressione Enter.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">5</div> Tela de instalação 2</div>
    <img src="img/017.png" alt="Tela instalação 2">
    <div class="install-step-desc">Em <strong>"Add commands directory to your PATH now? [y/N]"</strong>, digite <strong>Y</strong> e pressione Enter.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">6</div> Tela de instalação 3</div>
    <img src="img/018.png" alt="Tela instalação 3">
    <div class="install-step-desc">Em <strong>"Install CPython now? [y/N]"</strong>, digite <strong>Y</strong> e pressione Enter.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">7</div> Tela de instalação 4</div>
    <img src="img/019.png" alt="Tela instalação 4">
    <div class="install-step-desc">Instalação em andamento, aguarde.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">8</div> Tela de instalação 5</div>
    <img src="img/020.png" alt="Tela instalação 5">
    <div class="install-step-desc">Instalação em andamento, aguarde.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">9</div> Tela de instalação 6</div>
    <img src="img/021.png" alt="Tela instalação 6">
    <div class="install-step-desc">Em <strong>"View online help? [y/N]"</strong>, digite <strong>y</strong> e pressione Enter.</div>
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">10</div> Página de ajuda online do Python</div>
    <img src="img/022.png" alt="Página de Ajuda OnLine">
    <div class="install-step-desc">Página de ajuda online do Python. <strong>Pode fechar.</strong></div>
  </div>

  <p>Com o VSCode instalado, vamos dar um passo dentro dele. Na barra lateral esquerda você vai ver um ícone de quadradinhos, clique nele para abrir a aba de Extensões. Na caixa de busca, escreva <strong>Python</strong> e instale a primeira opção, a da Microsoft. Essa extenção irá adicionar cores no código, apontar erros em tempo real e é ela que vai conectar o VSCode com o Python. Feito isso, a gente está pronto para escrever código.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Primeiros Passos no VSCode - Extensões </div>
    <img src="img/023.png" alt="Primeiros Passos no VSCode 1">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Primeiros Passos no VSCode - Extensões </div>
    <img src="img/024.png" alt="Primeiros Passos no VSCode 2">
  </div>


  <p>Clique em <code>File</code> → <code>New File</code></p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Criando o Primeiro Arquivo </div>
    <img src="img/025.png" alt="Primeiro arquivo 1">
  </div>



  <p>Escolha <code>Python File</code>.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Criando o Primeiro Arquivo </div>
    <img src="img/026.png" alt="Primeiro arquivo 2">
  </div>

  <p>Vamos criar uma pasta para o nosso projeto. Vamos salvar esse arquivo.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Criando o Primeiro Arquivo </div>
    <img src="img/027.png" alt="Primeiro arquivo 3">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Criando o Primeiro Arquivo </div>
    <img src="img/028.png" alt="Primeiro arquivo 4">
  </div>

  <p>Agora que criamos o arquivo e a pasta, vamos definir esse local onde todos os arquivos desse projeto serão arqmazenados, para o VSCode.</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Definido a Pasta de Trabalho </div>
    <img src="img/029.png" alt="Primeiro arquivo 5">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Definido a Pasta de Trabalho </div>
    <img src="img/030.png" alt="Primeiro arquivo 6">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Definido a Pasta de Trabalho </div>
    <img src="img/031.png" alt="Primeiro arquivo 7">
  </div>


  <p>Vamos criar nosso primeiro programa, para tanto, precisaremos dar informações a ao sistema, para ele então processar e nos dar a resposta. Para guardar a informação que daremos, precisamos de uma <strong>variável</strong>. Pense em variáveis como como caixinhas com etiqueta: você coloca um valor dentro, dá um nome para a etiqueta, e pode pegar esse valor de volta sempre pesquisando pelo nome da etiquera. Em Python, criar uma variável é só dar um nome e usar o sinal de <code>=</code> para colocar algo dentro.</p>
 <p>Nossa primeira brincadeira será inserir o seguinte código no VSCode: <br>
<code>nome    = "Maria"  <br></code>
<code>idade   = 30    <br></code>
<code>altura  = 1.65<br></code>
<code>ativo   = True<br></code>
<code>print(nome)</code>
</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Meu Primeiro Código </div>
    <img src="img/032.png" alt="Primeiro Código">
  </div>

  <p>Observem que colocamos "Nome=", o que está antes do igual é o <strong>nome da variável</strong> e precisamos ter alguns cuidados para escolher os nomes dessas variáveis.</p>

<p><strong>Pode ter:</strong><br>
   - letras<br>
   - números<br>
   - underline<br>
<strong>Não pode:</strong><br>
   - começar com número<br>
   - ter espaço<br>
   - acento<br>
   - hífen nem outros símbolos<br>
<strong>Além disso:</strong> não pode usar palavras reservadas da linguagem, como if, for, while, class, def, import, porque essas palavras já têm função própria no Python.<br>
<br>
<strong>Exemplos válidos:</strong><br>
nome, idade, valor_total, data1<br>
<strong>Exemplos inválidos: </strong><br>
1nome, meu nome, ação, valor-total, if</p>

  <p>Ao atribuir valores às variáveis, o que vem depois do sinal de igual (=), é importante lembrar que: <strong>sempre que formos atribuir um valor de texto a variável, colocaremos o texto dentro de aspas</strong>. Textos fora de aspas serão considerados variáveis.</p>
  <p>Já os valores numéricos, colocamos eles apenas, assim o sistema já entenderá que é um número</p>

  <p>Aproveitando que estamos falando em primeiro código, é uma boa prática comentar os códigos que fazemos O símbolo # (hashtag) cria um comentário no Python, então ele ignora essa linha, usamos os comentários para explicar o que o código faz, ajudando os próximos desenvolvedores que venham a mexer no código.</p>
  <p>No nosso caso, vamos utilizar o siímbolo # para criar comentários que expliquem o código pra nós, para que possamos estudar a partir dos nossos exercícios, Ok?!</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">000_Exercicio.py</div>
    </div>
    <pre><span class="cm"># O símbolo # cria um comentário, o Python ignora essa linha</span>
<span class="cm"># Usamos comentários para explicar o que o código faz</span>

<span class="vr">nome</span>    <span class="op">=</span> <span class="st">"Maria"</span>   <span class="cm"># caixinha "nome" com "Maria" dentro</span>
<span class="vr">idade</span>   <span class="op">=</span> <span class="nm">30</span>         <span class="cm"># caixinha "idade" com o número 30</span>
<span class="vr">altura</span>  <span class="op">=</span> <span class="nm">1.65</span>       <span class="cm"># número com casas decimais</span>
<span class="vr">ativo</span>   <span class="op">=</span> <span class="kw">True</span>       <span class="cm"># verdadeiro ou falso</span>

<span class="fn">print</span>(<span class="vr">nome</span>)    <span class="cm"># mostra no terminal: Maria</span></pre>
  </div>

  <p>As programações em geral precisam que nós definamos o tipo de dado que será armazenado na variável, no caso do Python, por padrão, ele define o tipo, de acordo com o dado que você atribui a ele <strong>(tipagem dinâmica)</strong>. Porém é possivel fazermos essa definição. Temos os tipos: int, float, complex, str, bool, list, tuple, range, dict, set, frozenset, bytes, bytearray, memoryview, NoneType. Porém são quatro os tipos dados que vamos utilizar mais:</p>

  <div class="type-grid">
    <div class="tcard">
      <div class="tn">str</div>
      <div class="te">"Olá"<br>"Python"</div>
      <div class="td">Texto: sempre entre aspas</div>
    </div>
    <div class="tcard">
      <div class="tn">int</div>
      <div class="te">10<br>-5<br>200</div>
      <div class="td">Número inteiro</div>
    </div>
    <div class="tcard">
      <div class="tn">float</div>
      <div class="te">1.5<br>3.14</div>
      <div class="td">Número decimal</div>
    </div>
    <div class="tcard">
      <div class="tn">bool</div>
      <div class="te">True<br>False</div>
      <div class="td">Verdadeiro/Falso</div>
    </div>
  </div>


  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Por que True começa com T maiúsculo? Não posso escrever "true" em minúsculo?</div>
  </div>

  <p>Boa pergunta, e muito importante, não podemos escrever o True com letra minúscula, e isso me leva direto para uma das regras mais importantes do Python. <strong>Python é case sensitive</strong>, o que significa que letras maiúsculas e minúsculas são coisas completamente diferentes. <code>nome</code>, <code>Nome</code> e <code>NOME</code> são três variáveis distintas para o Python. <code>True</code> funciona porque é assim que o Python o reconhece como tipo booleano; <code>true</code> em minúsculo dá erro porque o Python simplesmente não sabe o que isso é.</p>

  <p>A outra regra sagrada é a <strong>indentação</strong>, os espaços no começo de uma linha. Em algumas linguagens eles são só estética. Em Python, eles definem a estrutura do código. Uma linha com 4 espaços na frente pertence ao bloco acima dela.Sem isso, o Python não consegue identificar quais linhas pertencem ao mesmo bloco de código.</p>

  <p><strong>Exemplo para ilustrar </strong></p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">001_Exercicio.py</div>
    </div>
    <pre><span class="cm"># ✅ correto: 4 espaços indicam que o print pertence ao if</span>
<span class="kw">if</span> <span class="nm">10</span> <span class="op">></span> <span class="nm">5</span>:
    <span class="fn">print</span>(<span class="st">"dez é maior"</span>)

<span class="cm"># ❌ erro: sem indentação o Python não entende a estrutura</span>
<span class="kw">if</span> <span class="nm">10</span> <span class="op">></span> <span class="nm">5</span>:
<span class="fn">print</span>(<span class="st">"dez é maior"</span>)</pre>
  </div>

  <div class="dica">
    O VSCode indenta automaticamente quando você aperta Enter depois de uma linha que termina com <code>:</code> ele já pula para o próximo nível com 4 espaços. Nunca misture espaços e Tab no mesmo projeto.
  </div>

  <!-- BREAK - meio da aula -->
  <div class="break">
    <span class="be">☕</span>
    <h3>Pausa rápida para o café!</h3>
    <p>Levanta, estica as pernas, beba uma água ou um café. A mente aprende melhor com pausas curtas. Volte com energia!</p>
  </div>

  <p>Voltou? Está pronto para continuar? Ótimo. Agora vamos olhar novamente para aquele código que digitamos no VSCode. <i>Nosso primeiro código</i>.<p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Código Comentado </div>
    <img src="img/033.png" alt="Código Comentado">
  </div>

  <p>Deixei o código todo comentado explicando cada parte dele, o que ainda não tínhamos falado é que apesar das variáveis estaram guardando os nossos dados, precisamos de alguma forma de visualizar esses dados. E aqui nesse caso, utlizamos o print, que mostrará os valores atribuídos a cada variável, na ordem que solicitamos.<p>

  <p>Para executar o código, basta clicar no botão de execução ou usar o atalho Ctrl + Enter.<p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Botão de Executar </div>
    <img src="img/034.png" alt="Botão Executar">
  </div>

  <p>Ao executarmos, o VSCode mostra o terminal onde aparece algumas linhas padrão, junto com o retornoque solcitamos. É um terminal chamado PowerShell, por isso as linhas que não são respostas da nossa programação começam com PS. Nessas linhas ele também apresenta a pasta em que estamos trabalhando. Isso não é preciso decorar, é só para que você não assuste ao terminar a execução.<p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">*</div> Código Executado </div>
    <img src="img/035.png" alt="Código Executado">
  </div>

<p> Vamos fazer mais um teste? Feche esse arquivo crie mais um, lembra como é?</p>
<p> Agora vamos digitar <code>def cumprimento():</code><br>
 Na linha debaixo <code>&nbsp &nbsp &nbsp &nbsp print("Olá! Tudo bem?")</code><br>
<i>Observe a identação dessa linha, já falamos sobre isso</i><br>
 Na linha debaixo <code>if __name__ == "__main__":</code><br>
 E na última linha <code>&nbsp &nbsp &nbsp &nbsp cumprimento()</code><br>


<p> Uma regra geral de programação: <strong>todo programa, módulo ou função precisa de um nome.</strong> Nessa primeira atividade vamos criar uma função chamada <strong>cumprimento</strong>. Para dizer ao Python "vou definir uma função agora", usamos a palavra <code>def</code>, abreviação de <em>define</em>.</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">002_Exercicio.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">cumprimento</span>():
    <span class="fn">print</span>(<span class="st">"Olá! Tudo bem?"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">cumprimento</span>()</pre>
  </div>

  <p>Vamos entender cada parte: palavra por palavra:</p>

  <table class="code-ann">
    <tr>
      <td>def</td>
      <td><strong>Palavra reservada do Python</strong> que diz "vou definir uma função agora". Marca o início de um bloco de código com nome. Sempre vem antes do nome da função.</td>
    </tr>
    <tr>
      <td>cumprimento</td>
      <td><strong>O nome que demos à função.</strong> Poderia ser qualquer nome descritivo. Escolhemos "cumprimento" porque é o que ela faz. Sem espaços, sem acentos nos nomes de funções, é boa prática.</td>
    </tr>
    <tr>
      <td>()</td>
      <td><strong>Os parênteses</strong> fazem parte da sintaxe de toda função. Por enquanto estão vazios, mas mais à frente vamos colocar parâmetros dentro, informações que a função recebe para trabalhar.</td>
    </tr>
    <tr>
      <td>:</td>
      <td><strong>Os dois pontos</strong> encerram a linha de definição e dizem ao Python "o corpo da função começa na próxima linha, indentado". Sempre que você ver <code>:</code> no final de uma linha, o que vem depois precisa estar indentado.</td>
    </tr>
    <tr>
      <td>print(...)</td>
      <td><strong>Função embutida do Python</strong> que mostra algo na tela, no terminal. É o nosso "msgbox" da vida real. Tudo que você colocar entre os parênteses aparece no terminal quando o código executa.</td>
    </tr>
    <tr>
      <td>if __name__ == "__main__":</td>
      <td><strong>O ponto de entrada do programa.</strong> Garante que a função só executa quando você rodar esse arquivo diretamente. Se outro arquivo importar esse código, a função não inicia sozinha. Pense nele como o "gatilho" que dispara tudo, é aqui que o programa começa a rodar de verdade.</td>
    </tr>

    </tr>
    <tr>
      <td>if</td>
      <td>Função condicional, Se uma determinada condição for verdadeira, ele dá uma resposta, senão ele datá outra resposta</td>
    </tr>

    </tr>
    <tr>
      <td>__name__</td>
      <td><strong>É uma variável especial do Python. Ela guarda o nome do módulo/arquivo em execução.</td>
    </tr>

    </tr>
    <tr>
      <td>==</td>
      <td>É o operador de comparação. Significa “é igual a”.</td>
    </tr>

    </tr>
    <tr>
      <td>"__main__"</td>
      <td>É um texto especial que o Python usa quando o arquivo está sendo executado diretamente, o próprio arquivo é o ponto de início do programa. É o valor que o Python usa quando o arquivo está sendo executado como programa principal, e não apenas importado por outro arquivo.</td>
    </tr>

    <tr>
      <td>cumprimento()</td>
      <td><strong>A chamada da função.</strong> Definir com <code>def</code> só cadastra a função, não a executa. Para ela realmente rodar, você precisa chamá-la pelo nome seguido de parênteses. É aqui que o programa "entra" na função.</td>
    </tr>
  </table>

  <p>Salve o arquivo, vamos executar! Você lembra como fazer, né?. O terminal aparece na parte de baixo da tela e mostra:</p>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">1</div> 2º Código Executado </div>
    <img src="img/036.png" alt="Código Executado 2">
  </div>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Retorno do 2º Código Executado </div>
    <img src="img/037.png" alt="Código Executado 3">
  </div>


  <p>Funcionou! Agora vamos deixar mais interessante, em vez de só falar, a função vai <strong>perguntar</strong> o nome do usuário. Para isso usamos o <code>input()</code>, uma função embutida do Python que pausa o programa e espera o usuário digitar algo. Tudo que ele digitar fica guardado numa variável:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">003_Exercicio.py</div>
    </div>
    <pre><span class="kw">def</span> <span class="fn">cumprimento</span>():
    <span class="vr">nome</span> <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Qual é o seu nome? "</span>)
    <span class="fn">print</span>(<span class="st">f"Olá, {</span><span class="vr">nome</span><span class="st">}! Tudo bem?"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">cumprimento</span>()</pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>input("Qual é o seu nome? ")</td>
      <td><strong>Mostra a pergunta na tela, espera o usuário digitar e apertar Enter</strong>, e devolve o texto digitado. É como aquelas caixinhas que aparecem em sites pedindo seu nome ou e-mail, só que no terminal.</td>
    </tr>
    <tr>
      <td>nome = input(...)</td>
      <td>Cria a variável <code>nome</code> e <strong>guarda dentro dela</strong> o texto que o usuário digitou. A partir daqui, toda vez que você escrever <code>nome</code> no código, o Python vai buscar esse valor.</td>
    </tr>
    <tr>
      <td>f"Olá, {nome}!"</td>
      <td><strong>F-string</strong>, coloque <code>f</code> antes das aspas e a variável entre chaves <code>{}</code>. O Python substitui automaticamente pelo valor. É a forma mais limpa de misturar texto fixo com variáveis.</td>
    </tr>
  </table>

  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Retorno do 3º Código Executado </div>
    <img src="img/038.png" alt="Código Executado 4">
  </div>

<br>
  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Posso usar aspas simples ou duplas? Vi os dois sendo usados...</div>
  </div>

  <p>Pode usar os dois! Python aceita aspas simples <code>'assim'</code> e duplas <code>"assim"</code> para textos. O importante é abrir e fechar com o mesmo tipo. Usamos duplas por convenção, mas quando o texto contém uma aspa simples (como em "não deu"), fica mais cômodo usar duplas por fora.</p>

  <div class="aviso">
    <strong>Apareceu erro vermelho no terminal?</strong> Faz parte, erro é aprendizado. Grande parte do trabalho de programação é ler, entender e corrigir erros. Se travar em algum, seleciona o texto do erro e cola no Google, ou pede ajuda para a IA. Vai encontrar a solução na maioria das vezes em menos de 2 minutos.
  </div>

  <p>Antes irmos para o próximo exercício, tem mais uma coisa que você precisa saber: como o Python toma decisões. Pensa assim, se você fosse um porteiro e precisasse liberar só maiores de 18, o que você faria? Verificaria a idade. Se for maior, libera. Se não for, não libera. Em Python, fazemos isso com o <code>if</code> e o <code>else</code>:</p>

  <div class="cblock">
    <div class="cblock-head">
      <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
      <div class="cfname">004_Exercicio.py</div>
    </div>
    <pre><span class="vr">idade</span> <span class="op">=</span> <span class="nm">20</span>

<span class="kw">if</span> <span class="vr">idade</span> <span class="op">>=</span> <span class="nm">18</span>:
    <span class="fn">print</span>(<span class="st">"Pode entrar!"</span>)      <span class="cm"># executa se a condição for verdadeira</span>
<span class="kw">else</span>:
    <span class="fn">print</span>(<span class="st">"Não pode entrar."</span>)   <span class="cm"># executa se a condição for falsa</span></pre>
  </div>

  <table class="code-ann">
    <tr>
      <td>if</td>
      <td><strong>"Se"</strong>: avalia uma condição. Se for verdadeira, executa o bloco indentado abaixo. Sempre seguido de <code>:</code> e do bloco indentado.</td>
    </tr>
    <tr>
      <td>idade >= 18</td>
      <td><strong>A condição.</strong> O Python avalia se isso é verdadeiro ou falso. <code>>=</code> significa "maior ou igual". Outros operadores: <code>></code> maior, <code>&lt;</code> menor, <code>==</code> igual, <code>!=</code> diferente.</td>
    </tr>
    <tr>
      <td>else:</td>
      <td><strong>"Senão"</strong>: o que acontece quando a condição do <code>if</code> for falsa. Não precisa de condição própria, é o "caso contrário".</td>
    </tr>
  </table>


  <div class="install-step">
    <div class="install-step-head"><div class="install-num">2</div> Retorno do 4º Código Executado </div>
    <img src="img/039.png" alt="Código Executado 5">
  </div>



  <p>Agora sim você tem tudo que precisa para o exercício. Programação se aprende fazendo, então quero que você tente isso no VSCode agora mesmo. Se der erro, ótimo, faz parte. Experimenta, pesquisa, quebra a cabeça. É assim que a coisa entra de verdade.</p>

  <div class="exercise">
    <span class="ex-tag">⚡ exercício -> seu primeiro mini-programa</span>
    <h3>Crie um programa que faça o seguinte:</h3>
    <ol>
      <li>Pergunte o nome do usuário</li>
      <li>Pergunte a idade do usuário</li>
      <li>Mostre uma mensagem de boas-vindas com o nome</li>
      <li>Se a idade for menor que 18, escreva "Você é jovem!"</li>
      <li>Se for 18 ou mais, escreva "Bem-vindo, adulto!"</li>
    </ol>
    <div class="ex-ans">
      <button class="btn-ans" onclick="toggleAns(this)">▶ ver uma possível solução</button>
      <div class="ex-ans-body">
        <span class="ex-ans-tag" style="margin-top:12px">// uma possível solução</span>
        <div class="cblock" style="margin:0">
          <div class="cblock-head">
            <div class="cdots"><span class="c1"></span><span class="c2"></span><span class="c3"></span></div>
            <div class="cfname">005_Exercicio.py</div>
          </div>
          <pre><span class="kw">def</span> <span class="fn">boas_vindas</span>():
    <span class="vr">nome</span>  <span class="op">=</span> <span class="fn">input</span>(<span class="st">"Qual é o seu nome? "</span>)
    <span class="vr">idade</span> <span class="op">=</span> <span class="fn">int</span>(<span class="fn">input</span>(<span class="st">"Qual é a sua idade? "</span>))  <span class="cm"># int() converte texto em número</span>

    <span class="fn">print</span>(<span class="st">f"Olá, {</span><span class="vr">nome</span><span class="st">}! Seja bem-vindo(a)!"</span>)

    <span class="kw">if</span> <span class="vr">idade</span> <span class="op">&lt;</span> <span class="nm">18</span>:
        <span class="fn">print</span>(<span class="st">"Você é jovem!"</span>)
    <span class="kw">else</span>:
        <span class="fn">print</span>(<span class="st">"Bem-vindo, adulto!"</span>)

<span class="kw">if</span> <span class="bi">__name__</span> <span class="op">==</span> <span class="st">"__main__"</span>:
    <span class="fn">boas_vindas</span>()</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="bubble">
    <div class="bubble-avatar">🙋</div>
    <div class="bubble-body">Por que tem int() na frente do input() da idade? Não dá pra usar direto?</div>
  </div>

  <p>Boa observação! O <code>input()</code> sempre devolve texto, mesmo que o usuário digite o número 30, o Python recebe a string "30", não o número 30. E você não consegue fazer comparações matemáticas com texto. O <code>int()</code> converte esse texto em número inteiro para que o <code>if idade &lt; 18</code> funcione corretamente. Pensa assim: se alguém te entrega um papel escrito "30", isso é texto. Você precisa interpretar aquilo como o número 30 para fazer uma conta. O <code>int()</code> faz exatamente essa interpretação.</p>

  <div class="lousa">
    <div class="lousa-title">o que aprendemos</div>
    <div class="lousa-row"><span class="bul">→</span><span><code>def nome():</code>  define uma função</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>()</code>  parênteses sempre na definição e na chamada</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>:</code>  sinaliza que o próximo bloco está indentado</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>print()</code>  mostra algo na tela</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>input()</code>: recebe texto do usuário</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>int()</code>: converte texto em número</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>f"texto {variavel}"</code>  mistura texto com variáveis</span></div>
    <div class="lousa-row"><span class="bul">→</span><span><code>if condição:</code> / <code>else:</code>  tomada de decisão</span></div>
    <div class="lousa-row"><span class="bul">→</span><span>Indentação obrigatória: 4 espaços dentro de <code>def</code>, <code>if</code> e <code>else</code></span></div>
  </div>

  <div class="downloads">
    <span class="downloads-title">// arquivos desta aula</span>
    <div class="dl-grid">

      <a class="dl-item" href="arquivos/001_Exercício.py" download>
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">001_Exercício.py</div>
          <div class="dl-desc">Variáveis e tipos de dados: str, int, float, bool</div>
        </div>
        <span class="dl-badge">↓ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/002_Exercício.py" download>
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">002_Exercício.py</div>
          <div class="dl-desc">Primeira função: def, print() e if __name__</div>
        </div>
        <span class="dl-badge">↓ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/003_Exercício.py" download>
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">003_Exercício.py</div>
          <div class="dl-desc">Entrada do usuário: input() e f-string</div>
        </div>
        <span class="dl-badge">↓ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/004_Exercício.py" download>
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">004_Exercício.py</div>
          <div class="dl-desc">Tomada de decisão: if e else</div>
        </div>
        <span class="dl-badge">↓ visualizar</span>
      </a>

      <a class="dl-item" href="arquivos/005_Exercício.py" download>
        <span class="dl-icon">🐍</span>
        <div class="dl-info">
          <div class="dl-name">005_Exercício.py</div>
          <div class="dl-desc">Exercício completo: boas_vindas() com nome, idade e condição</div>
        </div>
        <span class="dl-badge">↓ visualizar</span>
      </a>

    </div>
  </div>

  <div class="ready">
    <span class="re">🎉</span>
    <h2>Pronto para a Aula 1!</h2>
    <p>Com essas bases, já conseguimos avançar. Vamos criar um chatbot de verdade!</p>
  </div>

  <div class="nav-bottom">
    <a class="nav-link" href="AulaChatbot.html">⊞ índice</a>
    <a class="nav-link next" href="aula1.php">Aula 1 →</a>
  </div>

</div>

<p style="font-size: 14px;">
<!--contador-->
<?php include 'contador.php'; ?>
<!------------------------------------------>
</p>

<footer>
  <span>Chatbots com Python · nivelamento</span>
  <span><a href="AulaChatbot.html" style="color:inherit;text-decoration:none;">← índice</a></span>
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
