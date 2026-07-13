const fs = require('fs');
const path = require('path');

const ROOT = path.join(__dirname, '..');
const cssRaw = fs.readFileSync('/tmp/extracted-style.css', 'utf8');
const css = cssRaw.replace(/^<style>\n?/, '').replace(/<\/style>\s*$/, '');

const previewBody = fs.readFileSync(path.join(__dirname, 'preview-body.html'), 'utf8');
const editorJs = fs.readFileSync(path.join(__dirname, 'editor.js'), 'utf8');

const previewDoc = `<!doctype html><html><head><meta charset="utf-8">
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600&family=Meow+Script&display=swap" rel="stylesheet">
<style>${css}
body{padding-top:0;}
[data-hide-if-empty],[data-hide-if-empty-img]{transition:none;}
img:not([src]){visibility:hidden;}
</style></head><body>${previewBody}</body></html>`;

const previewDocEscaped = previewDoc.replace(/&/g, '&amp;').replace(/"/g, '&quot;');

const html = `<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Éditeur Landing Guide — Region Lovers</title>
<style>
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; height: 100%; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; }
  body { display: flex; flex-direction: column; background: #f4f5f8; color: #191E55; }

  .topbar {
    background: #191E55;
    color: #fff;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }
  .topbar h1 { font-size: 15px; margin: 0; font-weight: 700; color: #B68207; text-transform: uppercase; letter-spacing: .04em; }
  .topbar select, .topbar button {
    font: inherit; font-size: 13px; padding: 7px 12px; border-radius: 6px; border: none; cursor: pointer;
  }
  .topbar select { background: #2d3490; color: #fff; }
  .topbar button { background: rgba(255,255,255,0.12); color: #fff; }
  .topbar button:hover { background: rgba(255,255,255,0.22); }
  .topbar .spacer { flex: 1; }
  #export-btn { background: #B68207 !important; color: #191E55 !important; font-weight: 700; }
  #export-btn:hover { background: #c8930f !important; }
  #publish-btn { background: #2e7d32 !important; color: #fff !important; font-weight: 700; }
  #publish-btn:hover { background: #388e3c !important; }
  #export-status { font-size: 12px; color: #CCD3DD; max-width: 320px; }
  .sync-status { font-size: 12px; color: #B68207; font-style: italic; }

  .main { flex: 1; display: flex; min-height: 0; }

  .sidebar { width: 420px; flex-shrink: 0; background: #fff; border-right: 1px solid #e2e4ea; display: flex; flex-direction: column; }
  .tabs { display: flex; flex-wrap: wrap; gap: 4px; padding: 10px; border-bottom: 1px solid #e2e4ea; background: #fafafd; }
  .tab-btn {
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em;
    padding: 6px 10px; border-radius: 20px; border: 1px solid #d5d8e2; background: #fff; color: #4a5168; cursor: pointer;
  }
  .tab-btn.active { background: #191E55; color: #fff; border-color: #191E55; }

  #form { flex: 1; overflow-y: auto; padding: 16px; }
  .field-group { margin-bottom: 22px; }
  .field-group h3 { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: #B68207; margin: 0 0 10px; border-bottom: 1px solid #eee; padding-bottom: 6px; }
  .field-row { display: block; margin-bottom: 12px; }
  .field-label { display: block; font-size: 12px; color: #4a5168; margin-bottom: 4px; }
  .field-note { font-size: 12px; color: #8a6200; background: #FBF3DF; padding: 8px 12px; border-radius: 6px; margin: 0 0 14px; line-height: 1.5; }
  .field-row input[type=text], .field-row input[type=url], .field-row textarea {
    width: 100%; font: inherit; font-size: 13px; padding: 8px 10px; border: 1px solid #d5d8e2; border-radius: 6px; resize: vertical;
  }
  .field-row textarea { min-height: 60px; }
  .field-row input:focus, .field-row textarea:focus { outline: 2px solid #B68207; border-color: #B68207; }

  .image-field { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
  .image-preview { width: 64px; height: 64px; object-fit: cover; border-radius: 6px; border: 1px solid #d5d8e2; background: #f0f0f4; }
  .image-status { font-size: 11px; color: #B68207; font-style: italic; }
  .btn-clear { font-size: 11px; padding: 4px 8px; border-radius: 6px; border: 1px solid #d5d8e2; background: #fff; cursor: pointer; }

  .preview-wrap { flex: 1; overflow: auto; background: #ddd; padding: 20px; display: flex; justify-content: center; }
  #preview-frame { width: 100%; max-width: 1400px; height: 900px; border: none; background: #fff; box-shadow: 0 0 30px rgba(0,0,0,0.15); }

  /* ---- Volet Mode d'emploi ---- */
  #guide-toggle {
    position: fixed; top: 50%; right: 0; transform: translateY(-50%);
    z-index: 20;
    background: #191E55; color: #B68207; border: none; cursor: pointer;
    padding: 14px 8px; border-radius: 8px 0 0 8px; font-size: 12px; font-weight: 700;
    writing-mode: vertical-rl; text-transform: uppercase; letter-spacing: .05em;
    box-shadow: -2px 0 10px rgba(0,0,0,0.15);
  }
  #guide-toggle:hover { background: #2d3490; }

  #guide-panel {
    position: fixed; top: 0; right: 0; bottom: 0; width: 420px; max-width: 90vw;
    background: #fff; border-left: 1px solid #e2e4ea; z-index: 19;
    transform: translateX(100%); transition: transform 0.25s ease;
    display: flex; flex-direction: column; box-shadow: -6px 0 24px rgba(0,0,0,0.15);
  }
  #guide-panel.open { transform: translateX(0); }

  .guide-header {
    background: #191E55; color: #fff; padding: 16px 20px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: space-between;
  }
  .guide-header h2 { font-size: 15px; margin: 0; color: #B68207; text-transform: uppercase; letter-spacing: .04em; }
  .guide-close { background: none; border: none; color: #fff; font-size: 20px; cursor: pointer; line-height: 1; }

  #guide-body { flex: 1; overflow-y: auto; padding: 18px 20px; }

  .guide-step { display: flex; gap: 12px; margin-bottom: 22px; }
  .guide-step-num {
    flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%; background: #191E55; color: #B68207;
    font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center;
  }
  .guide-step-body h4 { margin: 0 0 6px; font-size: 13px; color: #191E55; }
  .guide-step-body p { margin: 0 0 8px; font-size: 12.5px; color: #4a5168; line-height: 1.5; }
  .guide-step-body ol { margin: 6px 0 8px; padding-left: 18px; font-size: 12.5px; color: #4a5168; line-height: 1.6; }
  .guide-step-body ol li { margin-bottom: 6px; }
  .guide-step-body code {
    background: #f2f2f6; border-radius: 4px; padding: 1px 5px; font-size: 11.5px;
    font-family: 'Courier New', monospace; display: inline-block; line-height: 1.6;
  }
  .guide-note { font-size: 11.5px; color: #8a6200; background: #FBF3DF; padding: 6px 10px; border-radius: 6px; }
  .guide-checklist { list-style: none; margin: 0; padding: 0; }
  .guide-checklist li { margin-bottom: 8px; font-size: 12.5px; color: #4a5168; }
  .guide-checklist label { display: flex; align-items: center; gap: 8px; cursor: pointer; }

  @media (max-width: 1000px) {
    .main { flex-direction: column; }
    .sidebar { width: 100%; height: 45vh; }
  }
</style>
</head>
<body>

<div class="topbar">
  <h1>Éditeur Landing Guide</h1>
  <select id="project-select"></select>
  <button id="new-project-btn">+ Nouveau</button>
  <button id="duplicate-project-btn">Dupliquer</button>
  <button id="reset-project-btn">Réinitialiser (contenu Tenerife)</button>
  <button id="delete-project-btn">Supprimer</button>
  <span id="sync-status" class="sync-status"></span>
  <div class="spacer"></div>
  <span id="export-status"></span>
  <button id="export-btn">Télécharger le ZIP (fichiers + images)</button>
  <button id="publish-btn">Publier en ligne</button>
</div>

<div class="main">
  <div class="sidebar">
    <div class="tabs" id="tabs"></div>
    <div id="form"></div>
  </div>
  <div class="preview-wrap">
    <iframe id="preview-frame" srcdoc="${previewDocEscaped}"></iframe>
  </div>
</div>

<button id="guide-toggle">Mode d'emploi</button>
<div id="guide-panel">
  <div class="guide-header">
    <h2>Mode d'emploi</h2>
    <button class="guide-close" id="guide-close">✕</button>
  </div>
  <div id="guide-body"></div>
</div>

<script>
${editorJs}
</script>
</body>
</html>
`;

fs.writeFileSync(path.join(ROOT, 'editor', 'landing-editor.html'), html);
console.log('Built editor/landing-editor.html —', html.length, 'bytes');
