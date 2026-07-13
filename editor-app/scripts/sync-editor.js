const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const editorDir = path.join(__dirname, '..', '..', 'editor');
const publicDir = path.join(__dirname, '..', 'public');

execSync('node build.js', { cwd: editorDir, stdio: 'inherit' });

fs.mkdirSync(publicDir, { recursive: true });
fs.copyFileSync(
  path.join(editorDir, 'landing-editor.html'),
  path.join(publicDir, 'landing-editor.html')
);

console.log('Synced landing-editor.html into public/');
