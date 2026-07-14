const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const editorDir = path.join(__dirname, '..', '..', 'editor');
const repoRoot = path.join(__dirname, '..', '..');
const publicDir = path.join(__dirname, '..', 'public');

execSync('node build.js', { cwd: editorDir, stdio: 'inherit' });

fs.mkdirSync(publicDir, { recursive: true });
fs.copyFileSync(
  path.join(editorDir, 'landing-editor.html'),
  path.join(publicDir, 'landing-editor.html')
);
fs.copyFileSync(
  path.join(repoRoot, 'acf-landing-guide.json'),
  path.join(publicDir, 'acf-landing-guide.json')
);
fs.copyFileSync(
  path.join(repoRoot, 'page-landing-guide.php'),
  path.join(publicDir, 'page-landing-guide.php')
);

console.log('Synced landing-editor.html, acf-landing-guide.json and page-landing-guide.php into public/');
