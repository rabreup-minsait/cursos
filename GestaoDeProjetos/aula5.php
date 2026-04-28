<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Em Breve</title>
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
  <a class="tb-logo" href="../index.html">
    <div class="tb-logo-icon"><img src="img/logo.png" ></div>
    Gestão de Projetos Ageis
  </a>
  <div class="tb-nav">
    <a class="tb-btn" href="../index.html">⊞ índice</a>
    <span class="tb-lesson">aula 05 · Em Breve</span>
    <a class="tb-btn" href="aula4.php">←</a>
    <a class="tb-btn next" href="aula6.php">→</a>
  </div>
</header>

<div class="wrap">

  <div class="cover">
    <span class="cover-tag">aula 05</span>
    <h1>Em breve</h1>

</div>
</body>
</html>

