/* ============================================================
   Éditeur Landing Guide — Region Lovers
   Schéma des champs, formulaire, aperçu live, export de fichiers
   ============================================================ */

const TEXT = 'text';
const TEXTAREA = 'textarea';
const IMAGE = 'image';
const URL_T = 'url';
const NOTE = 'note';

function grp(label, fields) { return { label, fields }; }
function f(name, label, type = TEXT, placeholder = '') { return { name, label, type, placeholder }; }
function note(text) { return { type: NOTE, text }; }

const SCHEMA = [
  {
    tab: 'PROJET',
    groups: [
      grp('Ma page', [
        f('project_slug', 'Nom de la destination (ex: loire, tenerife)', TEXT, 'loire'),
      ]),
      grp('Publier en un clic', [
        note("Trois informations suffisent pour publier directement depuis cet écran, sans manipulation technique."),
        f('project_site_url', 'Adresse du site (ex: https://loirelovers.fr)', URL_T, 'https://loirelovers.fr'),
        f('project_wp_username', 'Nom d\'utilisateur WordPress (celui utilisé pour se connecter à l\'admin)', TEXT),
        f('project_wp_app_password', 'Mot de passe d\'application'),
        note("Comment l'obtenir : dans WordPress, aller sur Utilisateurs → Votre profil → tout en bas, section « Mots de passe d'application ». Taper un nom (ex: éditeur landing), cliquer sur « Ajouter » et copier le mot de passe généré ici. Il ne se ressaisit qu'une seule fois."),
      ]),
      grp('Avancé — pour un développeur (optionnel)', [
        f('project_ssh_host', 'Hôte SSH', TEXT),
        f('project_ssh_user', 'Utilisateur SSH', TEXT),
        f('project_wp_root', 'Dossier racine WordPress sur le serveur', TEXT, '~/sites/xxxxx/'),
      ]),
    ]
  },
  {
    tab: 'HERO',
    groups: [
      grp('En-tête (navigation)', [
        f('header_logo', 'Logo du site (barre de navigation en haut de page)', IMAGE),
      ]),
      grp('Couverture & titre', [
        f('hero_cover_image', 'Image de couverture du guide', IMAGE),
        f('hero_badge', 'Badge (ex: +15 000 vendus)'),
        f('hero_kicker', 'Kicker (ex: guide numérique · 161 pages)'),
        f('hero_title_dest', 'Titre — partie destination (majuscules)'),
        f('hero_title_em', 'Titre — partie en italique'),
        f('hero_subtitle', 'Sous-titre', TEXTAREA),
      ]),
      grp('Statistiques (4 max)', [
        f('hero_stat_1_num', 'Stat 1 — nombre'), f('hero_stat_1_label', 'Stat 1 — légende'),
        f('hero_stat_2_num', 'Stat 2 — nombre'), f('hero_stat_2_label', 'Stat 2 — légende'),
        f('hero_stat_3_num', 'Stat 3 — nombre'), f('hero_stat_3_label', 'Stat 3 — légende'),
        f('hero_stat_4_num', 'Stat 4 — nombre'), f('hero_stat_4_label', 'Stat 4 — légende'),
      ]),
      grp('Boutons', [
        f('hero_cta_primary', 'Texte bouton principal'),
        f('hero_cta_secondary', 'Texte bouton secondaire (optionnel)'),
      ]),
    ]
  },
  {
    tab: 'PIVOT',
    groups: [
      grp('Texte', [
        f('pivot_lede', 'Amorce (optionnel)'),
        f('pivot_title', 'Titre', TEXTAREA),
        f('pivot_body', 'Corps de texte', TEXTAREA),
        f('pivot_quote', 'Citation (optionnel)', TEXTAREA),
        f('pivot_quote_cite', 'Signature de la citation'),
      ]),
      grp('Images (3 max)', [
        f('pivot_image_1', 'Image 1', IMAGE),
        f('pivot_image_2', 'Image 2', IMAGE),
        f('pivot_image_3', 'Image 3', IMAGE),
      ]),
    ]
  },
  {
    tab: 'FEUILLETAGE',
    groups: [
      grp('Texte', [
        f('feuilletage_tag', 'Tag de section'),
        f('feuilletage_title', 'Titre'),
        f('feuilletage_intro', 'Intro (optionnel)', TEXTAREA),
      ]),
      grp('Images (6 max)', [1,2,3,4,5,6].map(i => f(`feuilletage_image_${i}`, `Image ${i}`, IMAGE))),
    ]
  },
  {
    tab: 'TABLEAU CONTENU',
    groups: [
      grp('Texte', [
        f('benefits_tag', 'Tag de section'),
        f('benefits_title', 'Titre'),
        f('benefits_th_1', 'Titre colonne 1'),
        f('benefits_th_2', 'Titre colonne 2'),
      ]),
      grp('Lignes (6 max)', [1,2,3,4,5,6].flatMap(i => [
        f(`benefit_${i}_feature`, `Ligne ${i} — élément`),
        f(`benefit_${i}_value`, `Ligne ${i} — bénéfice`, TEXTAREA),
      ])),
    ]
  },
  {
    tab: 'INSPIRATION',
    groups: [
      grp('Texte', [
        f('inspi_tag', 'Tag de section'),
        f('inspi_title', 'Titre'),
        f('inspi_intro', 'Intro (optionnel)', TEXTAREA),
        f('inspi_mockup_image', 'Image mockup smartphone', IMAGE),
      ]),
      grp('Cartes (12 max)', Array.from({length:12}, (_,i)=>i+1).flatMap(i => [
        f(`inspi_${i}_emoji`, `Carte ${i} — emoji`),
        f(`inspi_${i}_title`, `Carte ${i} — titre`),
        f(`inspi_${i}_desc`, `Carte ${i} — description`),
      ])),
    ]
  },
  {
    tab: 'SOCIAL PROOF',
    groups: [
      grp('Texte', [
        f('proof_tag', 'Tag de section'),
        f('proof_title', 'Titre'),
      ]),
      grp('Statistiques (3 max)', [1,2,3].flatMap(i => [
        f(`proof_stat_${i}_num`, `Stat ${i} — nombre`),
        f(`proof_stat_${i}_label`, `Stat ${i} — légende (utiliser un retour à la ligne si besoin)`, TEXTAREA),
      ])),
      grp('Avis (3 max)', [1,2,3].flatMap(i => [
        f(`review_${i}_text`, `Avis ${i} — texte`, TEXTAREA),
        f(`review_${i}_author`, `Avis ${i} — auteur`),
      ])),
    ]
  },
  {
    tab: 'ENGAGEMENTS',
    groups: [
      grp('Texte', [
        f('eng_portrait', 'Photo portrait', IMAGE),
        f('eng_tag', 'Tag de section'),
        f('eng_title', 'Titre (retour à la ligne possible)', TEXTAREA),
        f('eng_body_1', 'Paragraphe 1', TEXTAREA),
        f('eng_body_2', 'Paragraphe 2', TEXTAREA),
        f('eng_sig_name', 'Nom signature'),
        f('eng_sig_role', 'Rôle signature'),
        f('eng_box_label', 'Titre de la liste'),
      ]),
      grp('Engagements (10 max)', Array.from({length:10}, (_,i)=>i+1).map(i => f(`eng_item_${i}`, `Engagement ${i}`, TEXTAREA))),
    ]
  },
  {
    tab: 'CTA FINAL',
    groups: [
      grp('Texte & prix', [
        f('cta_tag', 'Tag de section (optionnel)'),
        f('cta_title', 'Titre'),
        f('cta_title_em', 'Titre — partie en italique'),
        f('cta_body', 'Corps de texte (optionnel)', TEXTAREA),
        f('cta_price_label', 'Libellé au-dessus du prix'),
        f('cta_price', 'Prix (nombre seul, ex: 21)'),
        f('cta_price_note', 'Note sous le prix'),
        f('cta_btn_label', 'Texte du bouton'),
        f('cta_url', 'URL de vente SendOwl', URL_T),
      ]),
      grp('Réassurances (4)', [
        f('cta_reassure_1', 'Ligne 1 gauche (gras)'),
        f('cta_reassure_2', 'Ligne 1 droite'),
        f('cta_reassure_3', 'Ligne 2 gauche'),
        f('cta_reassure_4', 'Ligne 2 droite'),
      ]),
    ]
  },
  {
    tab: 'FOOTER',
    groups: [
      grp('Footer', [
        f('footer_brand', 'Marque'),
        f('footer_copy', 'Copyright'),
        f('footer_contact_url', 'URL formulaire de contact', URL_T),
        f('footer_contact_label', 'Texte du lien contact'),
        f('footer_cgv_url', 'URL des CGV', URL_T),
        f('footer_cgv_label', 'Texte du lien CGV'),
        f('footer_legal_url', 'URL des mentions légales', URL_T),
        f('footer_legal_label', 'Texte du lien mentions légales'),
      ]),
    ]
  },
];

const ALL_FIELDS = SCHEMA.flatMap(t => t.groups.flatMap(g => g.fields)).filter(x => x.type !== NOTE);
const IMAGE_FIELDS = ALL_FIELDS.filter(x => x.type === IMAGE).map(x => x.name);

// Contenu par défaut : celui du guide Tenerife (canarias-lovers.com), utilisé
// comme gabarit de départ pour tout nouveau projet. On personnalise ensuite
// destination par destination sans repartir d'une page blanche.
const TENERIFE_DEFAULTS = {
  hero_badge: '+15 000 vendus',
  hero_kicker: 'guide numérique · 161 pages',
  hero_title_dest: 'TENERIFE VOUS ATTEND,',
  hero_title_em: 'construisez le voyage qui vous ressemble',
  hero_subtitle: 'Choisir les bonnes zones, les bons lieux, les bonnes ambiances — et partir avec un voyage pensé pour vous, pas pour tout le monde.',
  hero_stat_1_num: '112', hero_stat_1_label: 'lieux sélectionnés',
  hero_stat_2_num: '161', hero_stat_2_label: 'pages',
  hero_stat_3_num: '14', hero_stat_3_label: 'zones couvertes',
  hero_stat_4_num: '6', hero_stat_4_label: 'pages inspiration',
  hero_cta_primary: 'Obtenir le guide →',
  hero_cta_secondary: 'Voir le contenu',

  pivot_lede: "Trop d'infos, pas assez de clarté ?",
  pivot_title: 'La plupart des guides accumulent, le nôtre aide à choisir',
  pivot_body: "Le guide Tenerife Canarias Lovers n'est pas une base de données. C'est un outil de décision — pensé pour smartphone et tablette — conçu pour vous permettre de comprendre la destination avant de réserver, et de construire un voyage personnel, pas générique.",
  pivot_quote: '"Le guide vous aide à choisir. Notre site vous aide à organiser. Une philosophie simple, appliquée à chaque page."',
  pivot_quote_cite: '— CANARIAS LOVERS',

  feuilletage_tag: 'Un aperçu du guide',
  feuilletage_title: "Feuilletez avant d'acheter",
  feuilletage_intro: '112 lieux, 3 photos par lieu en moyenne, des cartes cliquables qui ouvrent la navigation GPS directement sur votre smartphone.',

  benefits_tag: 'Le contenu',
  benefits_title: 'Pour planifier avec plaisir, sans stress',
  benefits_th_1: "Ce qu'il y a dans le guide",
  benefits_th_2: 'Ce que vous en tirez concrètement',
  benefit_1_feature: '112 lieux', benefit_1_value: "Fini le tri infini. Une sélection éditoriale honnête à la place des listes exhaustives qui ne vous disent pas quoi choisir.",
  benefit_2_feature: '3 photos / lieu', benefit_2_value: "Vous visualisez l'ambiance avant d'y aller. La photo n'illustre pas — elle aide à décider.",
  benefit_3_feature: '1 carte par zone', benefit_3_value: 'Vous comprenez les distances réelles, construisez des journées cohérentes — et sur place, un tap ouvre la navigation GPS directement.',
  benefit_4_feature: '6 pages inspiration', benefit_4_value: 'Vous explorez selon vos envies du moment : volcans aujourd\'hui, plages demain.',
  benefit_5_feature: '1 lieu = 1 page', benefit_5_value: 'Comparer deux endroits prend 30 secondes. La décision devient simple, pas stressante.',
  benefit_6_feature: 'Liens vers le site', benefit_6_value: 'Les infos pratiques de notre site sont toujours à jour — sans que le guide ne vieillisse.',

  inspi_tag: 'Explorer par envies',
  inspi_title: "6 lectures thématiques, de l'île",
  inspi_intro: "En plus des 112 fiches lieux, le guide propose des entrées par ambiances — pour explorer Tenerife selon ce qui vous attire vraiment.",
  inspi_1_emoji: '🌋', inspi_1_title: 'Découvertes volcaniques', inspi_1_desc: 'Caldeira, coulées de lave, paysages lunaires',
  inspi_2_emoji: '🏖️', inspi_2_title: 'Plages et baignade', inspi_2_desc: 'Pour tous les goûts et profils',
  inspi_3_emoji: '🥾', inspi_3_title: 'Marches & randonnées', inspi_3_desc: 'Repères niveaux, paysages, durées',
  inspi_4_emoji: '🌿', inspi_4_title: 'Jardins & oasis urbaines', inspi_4_desc: 'Flore endémique et haltes vertes',
  inspi_5_emoji: '👨‍👩‍👧', inspi_5_title: 'Ambiances familiales', inspi_5_desc: 'Parcs, accès, durées adaptées',
  inspi_6_emoji: '🏛️', inspi_6_title: 'Architecture canarienne', inspi_6_desc: 'Patrimoine, balcons, villages historiques',

  proof_tag: 'Ils nous font confiance',
  proof_title: '15 000 voyageurs ont déjà choisi nos guides',
  proof_stat_1_num: '+15 000', proof_stat_1_label: 'Guides Region Lovers\nvendus',
  proof_stat_2_num: '+30 000', proof_stat_2_label: 'km parcourus\npar notre équipe',
  proof_stat_3_num: '100%', proof_stat_3_label: 'indépendant\naucun sponsor',
  review_1_text: '« C\'est le guide le plus complet que j\'ai trouvé et il rend l\'organisation d\'un voyage photographique beaucoup moins cauchemardesque. »', review_1_author: 'Noaemi',
  review_2_text: '« Excellent ! Super excitée d\'avoir trouvé quelque chose d\'aussi utile comparé aux autres livres que j\'ai achetés! »', review_2_author: 'Sarra',
  review_3_text: '« C\'est génial ! Je trouve le guide très bien écrit, avec beaucoup d\'informations pertinentes et utiles. Des informations telles que le temps nécessaire pour visiter un endroit sont très utiles pour planifier une visite. Et les photos sont incroyables – elles vous donnent vraiment envie d\'y aller »', review_3_author: 'Cristiana',

  eng_tag: 'Nos engagements',
  eng_title: 'Un guide qui\nvous respecte',
  eng_body_1: "À l'heure où les guides de voyage se multiplient sans que personne ne soit jamais sur place, nous faisons le choix inverse : chaque lieu dont nous parlons, nous l'avons visité. Chaque photo, nous l'avons prise.",
  eng_body_2: "Pas de contenu généré, pas d'informations recyclées. Un regard humain, de terrain, 100% indépendant.",
  eng_sig_name: 'Claire & Manu',
  eng_sig_role: 'Co-fondateurs · Region Lovers',
  eng_box_label: 'Les 10 engagements de Region Lovers',
  eng_item_1: 'Visiter tous les lieux dont nous vous parlons.',
  eng_item_2: 'Pour chaque ville, dormir dans au moins un hôtel, visiter ceux que nous recommandons.',
  eng_item_3: 'Pour chaque ville, manger dans au moins un restaurant, visiter ceux que nous sélectionnons.',
  eng_item_4: 'Payer intégralement toutes nos factures, refuser tout partenariat ou sponsoring.',
  eng_item_5: 'Mettre à jour périodiquement nos articles, avec l\'aide de nos lecteurs.',
  eng_item_6: 'Enrichir nos articles par nos expériences sur place.',
  eng_item_7: 'Utiliser à 99 % nos propres photos.',
  eng_item_8: 'Avoir une utilisation raisonnée et transparente des outils numériques, que nous alimentons avec nos informations vérifiées sur place.',
  eng_item_9: 'Informer sur le binôme voyageur/rédacteur qui a donné naissance à l\'article.',
  eng_item_10: 'Vous dire ce que nous faisons, et faire ce que nous vous disons !',

  cta_tag: 'Prêt à partir ?',
  cta_title: 'Tenerife vous attend,',
  cta_title_em: 'partez avec les bons choix',
  cta_body: 'Accès immédiat au guide numérique complet. Lisible sur smartphone, tablette et ordinateur. Connecté à notre site Canarias Lovers pour les informations pratiques à jour.',
  cta_price_label: 'Guide numérique — Accès immédiat',
  cta_price: '21',
  cta_price_note: 'Paiement unique · Téléchargement immédiat',
  cta_btn_label: 'Obtenir le guide →',
  cta_url: '#',
  cta_reassure_1: 'Plus de 15 000 guides vendus',
  cta_reassure_2: 'Optimisé smartphone & tablette',
  cta_reassure_3: 'Paiement sécurisé',
  cta_reassure_4: 'Téléchargement immédiat',

  footer_brand: 'Éditions Region Lovers · Canarias Lovers',
  footer_copy: '© 2025 Region Lovers · Guide Tenerife',
  footer_contact_url: 'https://canarias-lovers.com/contact/',
  footer_contact_label: 'Nous contacter',
  footer_cgv_url: 'https://canarias-lovers.com/conditions-generales-de-vente/',
  footer_cgv_label: 'CGV',
  footer_legal_url: 'https://canarias-lovers.com/politiques/',
  footer_legal_label: 'Mentions légales',
};

/* ---------------- State & persistence (API + MongoDB) ---------------- */

// Les projets sont stockés côté serveur (MongoDB) pour permettre à toute
// l'équipe d'y accéder et de reprendre le travail où il a été laissé, depuis
// n'importe quel poste. Le jeton d'authentification est posé par l'app
// Next.js parente dans localStorage (même origine que cet iframe).

function authHeaders() {
  const token = localStorage.getItem('auth_token');
  return token ? { Authorization: `Bearer ${token}` } : {};
}

async function apiCall(path, opts = {}) {
  const res = await fetch(path, {
    ...opts,
    headers: { 'Content-Type': 'application/json', ...authHeaders(), ...(opts.headers || {}) },
  });
  let json = null;
  try { json = await res.json(); } catch (e) { /* pas de corps JSON */ }

  if (res.status === 401) {
    try { window.parent.postMessage({ type: 'rl-session-expired' }, window.location.origin); } catch (e) { /* ignore */ }
  }

  return { ok: res.ok, status: res.status, json };
}

async function fetchProjectList() {
  const { ok, json } = await apiCall('/api/projects');
  if (!ok) throw new Error(json?.message || 'Erreur de chargement des projets.');
  return json.projects || [];
}

async function fetchProject(slug) {
  const { ok, status, json } = await apiCall(`/api/projects/${encodeURIComponent(slug)}`);
  if (status === 404) return null;
  if (!ok) throw new Error(json?.message || 'Erreur de chargement du projet.');
  return json.project;
}

async function saveProjectRemote(slug, d, imgs) {
  const { ok, json } = await apiCall(`/api/projects/${encodeURIComponent(slug)}`, {
    method: 'PUT',
    body: JSON.stringify({ data: d, images: imgs }),
  });
  if (!ok) throw new Error(json?.message || 'Erreur de sauvegarde.');
}

async function deleteProjectRemote(slug) {
  const { ok, json } = await apiCall(`/api/projects/${encodeURIComponent(slug)}`, { method: 'DELETE' });
  if (!ok) throw new Error(json?.message || 'Erreur de suppression.');
}

function setSyncStatus(text) {
  const el = document.getElementById('sync-status');
  if (el) el.textContent = text;
}

let currentSlug = null;
let data = {}; // { fieldName: string }
let images = {}; // { fieldName: { filename, dataUrl } }
let projectSlugs = [];
let saveTimer = null;

function newProjectData() {
  const d = {};
  ALL_FIELDS.forEach(fld => { if (fld.type !== IMAGE) d[fld.name] = TENERIFE_DEFAULTS[fld.name] || ''; });
  return d;
}

function persistCurrent() {
  if (!currentSlug) return;
  renderGuidePanel();
  clearTimeout(saveTimer);
  setSyncStatus('Modifications en attente...');
  saveTimer = setTimeout(async () => {
    try {
      setSyncStatus('Enregistrement...');
      await saveProjectRemote(currentSlug, data, images);
      setSyncStatus('Enregistré ✓');
      setTimeout(() => setSyncStatus(''), 1500);
    } catch (e) {
      console.error(e);
      setSyncStatus('Erreur de sauvegarde — voir la console');
    }
  }, 700);
}

/* ---------------- Form rendering ---------------- */

const formEl = document.getElementById('form');
const tabsEl = document.getElementById('tabs');
let activeTab = SCHEMA[0].tab;

function renderTabs() {
  tabsEl.innerHTML = '';
  SCHEMA.forEach(t => {
    const btn = document.createElement('button');
    btn.className = 'tab-btn' + (t.tab === activeTab ? ' active' : '');
    btn.textContent = t.tab;
    btn.onclick = () => { activeTab = t.tab; renderTabs(); renderForm(); };
    tabsEl.appendChild(btn);
  });
}

function fieldValue(name) {
  return data[name] || '';
}

function renderForm() {
  formEl.innerHTML = '';
  const tabDef = SCHEMA.find(t => t.tab === activeTab);
  tabDef.groups.forEach(group => {
    const gWrap = document.createElement('div');
    gWrap.className = 'field-group';
    const h = document.createElement('h3');
    h.textContent = group.label;
    gWrap.appendChild(h);

    group.fields.forEach(fld => {
      if (fld.type === NOTE) {
        const p = document.createElement('p');
        p.className = 'field-note';
        p.textContent = fld.text;
        gWrap.appendChild(p);
        return;
      }

      const row = document.createElement('label');
      row.className = 'field-row';
      const lbl = document.createElement('span');
      lbl.className = 'field-label';
      lbl.textContent = fld.label;
      row.appendChild(lbl);

      if (fld.type === IMAGE) {
        const wrap = document.createElement('div');
        wrap.className = 'image-field';
        const preview = document.createElement('img');
        preview.className = 'image-preview';
        const img = images[fld.name];
        if (img) preview.src = img.url;
        else preview.style.display = 'none';
        const status = document.createElement('span');
        status.className = 'image-status';
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = async () => {
          const file = input.files[0];
          if (!file) return;

          // aperçu instantané pendant l'envoi
          const tempReader = new FileReader();
          tempReader.onload = () => { preview.src = tempReader.result; preview.style.display = 'block'; };
          tempReader.readAsDataURL(file);

          status.textContent = 'Envoi vers WordPress...';
          const uploaded = await uploadImageToSite(file);
          if (!uploaded) {
            status.textContent = '';
            return;
          }
          images[fld.name] = uploaded;
          preview.src = uploaded.url;
          status.textContent = '';
          persistCurrent();
          updatePreviewImage(fld.name);
        };
        wrap.appendChild(preview);
        wrap.appendChild(input);
        wrap.appendChild(status);
        if (img) {
          const clear = document.createElement('button');
          clear.textContent = '✕ retirer';
          clear.type = 'button';
          clear.className = 'btn-clear';
          clear.onclick = () => { delete images[fld.name]; persistCurrent(); renderForm(); updatePreviewImage(fld.name); };
          wrap.appendChild(clear);
        }
        row.appendChild(wrap);
      } else {
        const input = document.createElement(fld.type === TEXTAREA ? 'textarea' : 'input');
        if (fld.type !== TEXTAREA) input.type = fld.type === URL_T ? 'url' : 'text';
        input.value = fieldValue(fld.name);
        input.placeholder = fld.placeholder || '';
        input.oninput = () => {
          data[fld.name] = input.value;
          persistCurrent();
          updatePreviewText(fld.name);
        };
        row.appendChild(input);
      }
      gWrap.appendChild(row);
    });
    formEl.appendChild(gWrap);
  });
}

/* ---------------- Preview binding ---------------- */

const iframe = document.getElementById('preview-frame');

function previewDoc() {
  return iframe.contentDocument;
}

function updatePreviewText(name) {
  const doc = previewDoc();
  if (!doc) return;
  const value = fieldValue(name);
  doc.querySelectorAll(`[data-field-text="${name}"]`).forEach(el => { el.textContent = value; });
  doc.querySelectorAll(`[data-field-text-nl2br="${name}"]`).forEach(el => {
    el.innerHTML = '';
    value.split('\n').forEach((line, i) => {
      if (i > 0) el.appendChild(doc.createElement('br'));
      el.appendChild(doc.createTextNode(line));
    });
  });
  doc.querySelectorAll(`[data-hide-if-empty="${name}"]`).forEach(el => {
    el.style.display = value.trim() ? '' : 'none';
  });
}

function updatePreviewImage(name) {
  const doc = previewDoc();
  if (!doc) return;
  const img = images[name];
  doc.querySelectorAll(`[data-field-img="${name}"]`).forEach(el => {
    if (img) { el.src = img.url; el.closest('[data-hide-if-empty-img]')?.style && (el.closest(`[data-hide-if-empty-img="${name}"]`).style.display = ''); }
    else { el.removeAttribute('src'); }
  });
  const wrapper = doc.querySelector(`[data-hide-if-empty-img="${name}"]`);
  if (wrapper) wrapper.style.display = img ? '' : 'none';
  doc.querySelectorAll(`[data-show-if-empty-img="${name}"]`).forEach(el => {
    el.style.display = img ? 'none' : '';
  });
}

function refreshWholePreview() {
  ALL_FIELDS.forEach(fld => {
    if (fld.type === IMAGE) updatePreviewImage(fld.name);
    else updatePreviewText(fld.name);
  });
}

iframe.addEventListener('load', refreshWholePreview);

/* ---------------- Project management ---------------- */

const projectSelect = document.getElementById('project-select');

function refreshProjectSelect() {
  projectSelect.innerHTML = '';
  projectSlugs.forEach(slug => {
    const opt = document.createElement('option');
    opt.value = slug;
    opt.textContent = slug;
    if (slug === currentSlug) opt.selected = true;
    projectSelect.appendChild(opt);
  });
}

async function loadProject(slug) {
  currentSlug = slug;
  setSyncStatus('Chargement...');

  let proj = null;
  try {
    proj = await fetchProject(slug);
  } catch (e) {
    console.error(e);
    setSyncStatus('Erreur de chargement — voir la console');
  }

  if (!proj) {
    data = newProjectData();
    images = {};
    data.project_slug = slug;
    if (!projectSlugs.includes(slug)) projectSlugs.push(slug);
    try {
      await saveProjectRemote(slug, data, images);
      setSyncStatus('');
    } catch (e) {
      console.error(e);
      setSyncStatus('Erreur de sauvegarde — voir la console');
    }
  } else {
    data = proj.data || {};
    images = proj.images || {};
    if (!data.project_slug) data.project_slug = slug;
    setSyncStatus('');
  }

  refreshProjectSelect();
  renderTabs();
  renderForm();
  refreshWholePreview();
  renderGuidePanel();
}

document.getElementById('new-project-btn').onclick = async () => {
  const slug = prompt('Nom du projet (ex: loire, tenerife, gran-canaria) :');
  if (!slug) return;
  const clean = slug.trim().toLowerCase().replace(/[^a-z0-9-]/g, '-');
  await loadProject(clean);
};

document.getElementById('duplicate-project-btn').onclick = async () => {
  if (!currentSlug) return;
  const slug = prompt('Nouveau nom pour la copie :', currentSlug + '-copie');
  if (!slug) return;
  const clean = slug.trim().toLowerCase().replace(/[^a-z0-9-]/g, '-');
  const copyData = JSON.parse(JSON.stringify(data));
  const copyImages = JSON.parse(JSON.stringify(images));
  copyData.project_slug = clean;
  try {
    setSyncStatus('Duplication...');
    await saveProjectRemote(clean, copyData, copyImages);
  } catch (e) {
    console.error(e);
    setSyncStatus('Erreur de duplication — voir la console');
    return;
  }
  if (!projectSlugs.includes(clean)) projectSlugs.push(clean);
  await loadProject(clean);
};

document.getElementById('reset-project-btn').onclick = () => {
  if (!currentSlug) return;
  if (!confirm(`Remplacer tout le texte du projet "${currentSlug}" par le contenu par défaut de Tenerife ? Les images et les réglages de l'onglet PROJET sont conservés.`)) return;
  const freshText = newProjectData();
  ALL_FIELDS.forEach(fld => {
    if (fld.type !== IMAGE && !fld.name.startsWith('project_')) {
      data[fld.name] = freshText[fld.name];
    }
  });
  persistCurrent();
  renderForm();
  refreshWholePreview();
};

document.getElementById('delete-project-btn').onclick = async () => {
  if (!currentSlug) return;
  if (!confirm(`Supprimer le projet "${currentSlug}" ? Cette action est irréversible pour toute l'équipe.`)) return;
  try {
    await deleteProjectRemote(currentSlug);
  } catch (e) {
    console.error(e);
    setSyncStatus('Erreur de suppression — voir la console');
    return;
  }
  projectSlugs = projectSlugs.filter(s => s !== currentSlug);
  if (projectSlugs.length) await loadProject(projectSlugs[0]);
  else await loadProject('tenerife');
};

projectSelect.onchange = () => loadProject(projectSelect.value);

/* ---------------- Export: populate-*.php ---------------- */

function phpEscape(str) {
  return String(str || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
}

function slugify(str) {
  return String(str || '').trim().toLowerCase()
    .normalize('NFD').replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

function buildImagesMap(slug) {
  const map = {};
  IMAGE_FIELDS.forEach(name => {
    const img = images[name];
    if (!img) return;
    const ext = (img.filename.match(/\.[a-z0-9]+$/i) || ['.png'])[0];
    const filename = `${name.replace(/_/g, '-')}-${slug}${ext}`;
    map[name] = { filename, title: ALL_FIELDS.find(x => x.name === name)?.label || name, original: img };
  });
  return map;
}

function buildPopulatePhp() {
  const slug = data.project_slug || currentSlug || 'destination';
  const imgMap = buildImagesMap(slug);

  const imagesLines = Object.entries(imgMap)
    .map(([name, v]) => `\t'${name}' => [ '${v.filename}', '${phpEscape(v.title)}' ],`)
    .join('\n');

  const textFields = ALL_FIELDS.filter(x => x.type !== IMAGE && !x.name.startsWith('project_'));
  const fieldsLines = textFields
    .map(x => `\t'${x.name}' => '${phpEscape(data[x.name])}',`)
    .join('\n');

  return `<?php
/**
 * Script de pré-remplissage ACF — Guide ${slug}
 * Généré par l'éditeur landing-guide — ne pas exécuter deux fois.
 *
 * Usage WP-CLI (depuis la racine WordPress) :
 *   wp eval-file populate-${slug}.php
 */

function import_asset( string $filename, string $title = '' ): int|false {
\t$theme_dir = get_stylesheet_directory();
\t$file_path = $theme_dir . '/assets/' . $filename;

\tif ( ! file_exists( $file_path ) ) {
\t\tWP_CLI::warning( "Fichier introuvable : assets/{$filename} — champ image ignoré." );
\t\treturn false;
\t}

\t$slug     = sanitize_title( $title ?: pathinfo( $filename, PATHINFO_FILENAME ) );
\t$existing = get_posts( [
\t\t'post_type'      => 'attachment',
\t\t'name'           => $slug,
\t\t'posts_per_page' => 1,
\t\t'post_status'    => 'inherit',
\t] );
\tif ( $existing ) {
\t\tWP_CLI::log( "  · {$filename} — déjà dans la médiathèque (ID {$existing[0]->ID})" );
\t\treturn $existing[0]->ID;
\t}

\t$tmp = wp_tempnam( $filename );
\tcopy( $file_path, $tmp );

\t$file_array = [ 'name' => $filename, 'tmp_name' => $tmp ];

\trequire_once ABSPATH . 'wp-admin/includes/image.php';
\trequire_once ABSPATH . 'wp-admin/includes/file.php';
\trequire_once ABSPATH . 'wp-admin/includes/media.php';

\t$attachment_id = media_handle_sideload( $file_array, 0, $title ?: $filename );

\tif ( is_wp_error( $attachment_id ) ) {
\t\tWP_CLI::warning( "Erreur import {$filename} : " . $attachment_id->get_error_message() );
\t\treturn false;
\t}

\tWP_CLI::log( "  · {$filename} → médiathèque ID {$attachment_id}" );
\treturn $attachment_id;
}

$pages = get_posts( [
\t'post_type'      => 'page',
\t'posts_per_page' => 10,
\t'meta_key'       => '_wp_page_template',
\t'meta_value'     => 'page-landing-guide.php',
\t'post_status'    => 'any',
] );

if ( empty( $pages ) ) {
\tWP_CLI::error( 'Aucune page avec le template "Landing Guide" trouvée. Créez la page d\\'abord dans WP Admin.' );
\treturn;
}

$page = null;
foreach ( $pages as $p ) {
\tif ( stripos( $p->post_name, '${slug}' ) !== false || stripos( $p->post_title, '${slug}' ) !== false ) {
\t\t$page = $p;
\t\tbreak;
\t}
}
if ( ! $page ) { $page = $pages[0]; }

$page_id = $page->ID;
WP_CLI::log( "Page trouvée : \\"{$page->post_title}\\" (ID {$page_id})" );

WP_CLI::log( 'Import des images...' );

$images = [
${imagesLines || "\t// Aucune image ajoutée dans l'éditeur"}
];

$image_ids = [];
foreach ( $images as $field_name => [ $filename, $title ] ) {
\t$id = import_asset( $filename, $title );
\tif ( $id ) {
\t\t$image_ids[ $field_name ] = $id;
\t\tupdate_field( $field_name, $id, $page_id );
\t}
}

WP_CLI::log( '' );

$fields = [
${fieldsLines}
];

$count = 0;
foreach ( $fields as $field_name => $value ) {
\tif ( update_field( $field_name, $value, $page_id ) !== false ) { $count++; }
}

$img_count = count( $image_ids );
WP_CLI::success( "{$count} champ(s) texte mis à jour + {$img_count} image(s) importée(s) sur la page ID {$page_id}." );
`;
}

function buildDeploymentGuide() {
  const slug = data.project_slug || currentSlug || 'destination';
  const domain = data.project_site_url || '(à compléter)';
  const sshHost = data.project_ssh_host || '(à compléter)';
  const sshUser = data.project_ssh_user || '(à compléter)';
  const wpRoot = data.project_wp_root || '~/sites/xxxxx/';
  const imgMap = buildImagesMap(slug);
  const imgList = Object.values(imgMap).map(v => `  - ${v.filename}`).join('\n') || '  (aucune image)';

  return `MODE D'EMPLOI — Mise en ligne du guide "${slug}"
Site cible : ${domain}
================================================================

Ce fichier ZIP est le repli MANUEL, pour un développeur, à utiliser
uniquement si le bouton "Publier en ligne" de l'éditeur ne fonctionne pas
(site non compatible, pas d'accès admin, etc.). Dans le cas normal, la
publication en un clic ne nécessite ni SFTP ni ce fichier.

Fichiers générés par l'éditeur (dans ce dossier de téléchargement) :
  - populate-${slug}.php
${imgList}

ÉTAPE 1 — Déposer les fichiers sur le serveur (SFTP)
  Le thème utilisé sur tous nos sites est "genesis-sample".
  - Si le template "Landing Guide" n'a jamais servi sur ce site, déposer d'abord
      page-landing-guide.php
    dans wp-content/themes/genesis-sample/ (sinon WordPress refuse ce modèle de
    page avec l'erreur "Paramètre(s) invalide(s) : « template »"). Si déjà en
    place, passer directement aux fichiers suivants.
  - Déposer les images listées ci-dessus dans :
      wp-content/themes/genesis-sample/assets/
  - Déposer populate-${slug}.php à la racine WordPress : ${wpRoot}

ÉTAPE 2 — Créer la page WordPress
  1. Dans WP Admin (${domain}/wp-admin), Pages > Ajouter.
  2. Titre de la page + slug clair (ex: guide-${slug}).
  3. Dans "Attributs de la page", choisir le modèle "Landing Guide".
  4. Publier.

ÉTAPE 3 — Vérifier le groupe de champs ACF
  Si le template "Landing Guide" n'a jamais été utilisé sur ce site,
  importer d'abord acf-landing-guide.json dans ACF > Outils > Importer un JSON.
  Si déjà en place, passer à l'étape 4.

ÉTAPE 4 — Peupler les champs via WP-CLI
  ssh ${sshUser}@${sshHost}
  cd ${wpRoot}
  wp eval-file populate-${slug}.php

  En cas d'échec de connexion SSH ("Cannot access install"), vérifier dans
  my.wpengine.com que la clé SSH est bien associée à CET install précis.

ÉTAPE 5 — Vérifier le rendu
  Ouvrir la page publiée et comparer avec l'aperçu de l'éditeur.
  Vérifier en particulier : images, prix, bouton d'achat (cta_url).

ÉTAPE 6 — Traduction WPML (si le site est multilingue)
  1. WPML > Réglages > Traduction de champs personnalisés :
     - cta_url doit être en "Traduire" (chaque langue a sa propre URL SendOwl).
     - Tous les champs image (hero_cover_image, pivot_image_1/2/3,
       feuilletage_image_1 à 6, inspi_mockup_image, eng_portrait, header_logo)
       doivent RESTER en "Copier" (réglage par défaut) — ne pas les passer en
       "Traduire". Le template (page-landing-guide.php > rl_get_image())
       résout lui-même la bonne variante par langue via le filtre WPML
       wpml_object_id, à condition que le média ait été traduit (voir étape
       suivante).
     - Les autres champs (textes) peuvent rester en "Copier" sauf besoin
       spécifique.
  2. Traduire les médias : Médias > ouvrir chaque image utilisée dans le
     guide > onglet de traduction WPML de la pièce jointe > ajouter la
     variante pour chaque langue. Le champ ACF garde une seule référence
     (l'image FR) ; c'est cette table de traduction de médias que le
     template consulte pour choisir la bonne image selon la langue de la
     page affichée.
  3. Pages > cliquer sur le crayon sous chaque langue à traduire (jamais la
     traduction automatique en masse).
  4. Pour chaque langue, renseigner notamment cta_url avec l'URL SendOwl
     correspondante.
  5. Si un champ texte n'apparaît pas dans l'éditeur de traduction : ouvrir
     directement la page traduite dans l'éditeur WordPress standard (Pages >
     titre traduit > Modifier) et le renseigner là — tous les champs ACF s'y
     affichent normalement.

CHECKLIST FINALE
  [ ] Contenu relu (pas de texte "lorem" oublié)
  [ ] Toutes les images s'affichent
  [ ] cta_price et cta_url corrects pour chaque langue publiée
  [ ] Boutons "Obtenir le guide" (nav + hero + CTA final) renvoient vers SendOwl
  [ ] Liens CGV / Mentions légales / Contact fonctionnels
  [ ] Cache WP Engine purgé après la dernière modification
`;
}

function downloadBlob(filename, blob) {
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = filename;
  a.click();
  URL.revokeObjectURL(a.href);
}

/* ---- Minimal ZIP writer (store method, no compression, no deps) ---- */

const CRC_TABLE = (() => {
  const table = new Uint32Array(256);
  for (let n = 0; n < 256; n++) {
    let c = n;
    for (let k = 0; k < 8; k++) c = (c & 1) ? (0xEDB88320 ^ (c >>> 1)) : (c >>> 1);
    table[n] = c >>> 0;
  }
  return table;
})();

function crc32(bytes) {
  let crc = 0xFFFFFFFF;
  for (let i = 0; i < bytes.length; i++) {
    crc = CRC_TABLE[(crc ^ bytes[i]) & 0xFF] ^ (crc >>> 8);
  }
  return (crc ^ 0xFFFFFFFF) >>> 0;
}

function buildZip(files) {
  // files: [{ name: string, bytes: Uint8Array }]
  const encoder = new TextEncoder();
  const localParts = [];
  const centralParts = [];
  let offset = 0;

  files.forEach(file => {
    const nameBytes = encoder.encode(file.name);
    const crc = crc32(file.bytes);
    const size = file.bytes.length;

    const localHeader = new Uint8Array(30 + nameBytes.length);
    const lv = new DataView(localHeader.buffer);
    lv.setUint32(0, 0x04034b50, true);
    lv.setUint16(4, 20, true);
    lv.setUint16(6, 0, true);
    lv.setUint16(8, 0, true);
    lv.setUint16(10, 0, true);
    lv.setUint16(12, 0, true);
    lv.setUint32(14, crc, true);
    lv.setUint32(18, size, true);
    lv.setUint32(22, size, true);
    lv.setUint16(26, nameBytes.length, true);
    lv.setUint16(28, 0, true);
    localHeader.set(nameBytes, 30);

    localParts.push(localHeader, file.bytes);

    const centralHeader = new Uint8Array(46 + nameBytes.length);
    const cv = new DataView(centralHeader.buffer);
    cv.setUint32(0, 0x02014b50, true);
    cv.setUint16(4, 20, true);
    cv.setUint16(6, 20, true);
    cv.setUint16(8, 0, true);
    cv.setUint16(10, 0, true);
    cv.setUint16(12, 0, true);
    cv.setUint16(14, 0, true);
    cv.setUint32(16, crc, true);
    cv.setUint32(20, size, true);
    cv.setUint32(24, size, true);
    cv.setUint16(28, nameBytes.length, true);
    cv.setUint16(30, 0, true);
    cv.setUint16(32, 0, true);
    cv.setUint16(34, 0, true);
    cv.setUint16(36, 0, true);
    cv.setUint32(38, 0, true);
    cv.setUint32(42, offset, true);
    centralHeader.set(nameBytes, 46);
    centralParts.push(centralHeader);

    offset += localHeader.length + file.bytes.length;
  });

  const centralSize = centralParts.reduce((a, p) => a + p.length, 0);
  const centralOffset = offset;

  const endRecord = new Uint8Array(22);
  const ev = new DataView(endRecord.buffer);
  ev.setUint32(0, 0x06054b50, true);
  ev.setUint16(4, 0, true);
  ev.setUint16(6, 0, true);
  ev.setUint16(8, files.length, true);
  ev.setUint16(10, files.length, true);
  ev.setUint32(12, centralSize, true);
  ev.setUint32(16, centralOffset, true);
  ev.setUint16(20, 0, true);

  return new Blob([...localParts, ...centralParts, endRecord], { type: 'application/zip' });
}

document.getElementById('export-btn').onclick = async () => {
  const slug = data.project_slug || currentSlug || 'destination';
  const imgMap = buildImagesMap(slug);
  const encoder = new TextEncoder();
  const statusEl = document.getElementById('export-status');

  const files = [
    { name: `populate-${slug}.php`, bytes: encoder.encode(buildPopulatePhp()) },
    { name: `DEPLOIEMENT-${slug}.txt`, bytes: encoder.encode(buildDeploymentGuide()) },
  ];

  const entries = Object.entries(imgMap);
  for (let i = 0; i < entries.length; i++) {
    const [, v] = entries[i];
    statusEl.textContent = `Préparation des images (${i + 1}/${entries.length})...`;
    try {
      const res = await fetch(v.original.url);
      const bytes = new Uint8Array(await res.arrayBuffer());
      files.push({ name: `assets/${v.filename}`, bytes });
    } catch (e) {
      console.error(`Impossible de récupérer l'image ${v.filename}`, e);
    }
  }

  downloadBlob(`livraison-${slug}.zip`, buildZip(files));
  statusEl.textContent =
    `livraison-${slug}.zip téléchargé — ${entries.length} image(s) dans le dossier assets/ du zip, prêtes à glisser sur le serveur.`;
};

/* ---------------- Publication directe (API REST WordPress + ACF) ---------------- */

function basicAuthHeader(username, appPassword) {
  return 'Basic ' + btoa(`${username}:${appPassword}`);
}

function guessMime(filename) {
  const ext = (filename.match(/\.([a-z0-9]+)$/i) || [, 'png'])[1].toLowerCase();
  const map = { jpg: 'image/jpeg', jpeg: 'image/jpeg', png: 'image/png', gif: 'image/gif', webp: 'image/webp' };
  return map[ext] || 'application/octet-stream';
}

async function wpFetch(siteUrl, path, authHeader, opts = {}) {
  const res = await fetch(`${siteUrl}${path}`, {
    ...opts,
    headers: { Authorization: authHeader, ...(opts.headers || {}) },
  });
  let json = null;
  try { json = await res.json(); } catch (e) { /* réponse non-JSON */ }
  if (!res.ok) {
    const msg = json?.message || `${res.status} ${res.statusText}`;
    throw new Error(msg);
  }
  return json;
}

async function findPageId(siteUrl, slug, authHeader) {
  const results = await wpFetch(
    siteUrl,
    `/wp-json/wp/v2/pages?search=${encodeURIComponent(slug)}&per_page=50&status=publish,future,draft,pending,private&context=edit`,
    authHeader
  );
  const match = (results || []).find(p => {
    const tpl = typeof p.template === 'string' ? p.template : '';
    return tpl.includes('page-landing-guide.php') &&
      (p.slug.includes(slug) || (p.title?.raw || p.title?.rendered || '').toLowerCase().includes(slug));
  });
  if (match) return match.id;
  // repli : premier résultat utilisant le bon template, même sans correspondance de slug
  const fallback = (results || []).find(p => (p.template || '').includes('page-landing-guide.php'));
  return fallback ? fallback.id : null;
}

async function createPage(siteUrl, slug, authHeader) {
  const title = `Guide ${slug.charAt(0).toUpperCase()}${slug.slice(1)}`;
  const json = await wpFetch(siteUrl, '/wp-json/wp/v2/pages', authHeader, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      title,
      slug: `guide-${slug}`,
      status: 'publish',
      template: 'page-landing-guide.php',
    }),
  });
  return json.id;
}

async function uploadImage(siteUrl, authHeader, filename, bytes) {
  const json = await wpFetch(siteUrl, '/wp-json/wp/v2/media', authHeader, {
    method: 'POST',
    headers: {
      'Content-Disposition': `attachment; filename="${filename}"`,
      'Content-Type': guessMime(filename),
    },
    body: bytes,
  });
  return { mediaId: json.id, url: json.source_url };
}

// Envoie une image choisie localement directement dans la médiathèque
// WordPress du site configuré dans l'onglet PROJET, et ne conserve que le
// lien (URL + ID média) — jamais le fichier lui-même — pour rester léger
// côté stockage (Mongo) et éviter toute re-synchronisation manuelle.
async function uploadImageToSite(file) {
  const siteUrl = (data.project_site_url || '').replace(/\/+$/, '');
  const username = data.project_wp_username || '';
  const appPassword = data.project_wp_app_password || '';

  if (!siteUrl || !username || !appPassword) {
    alert("Renseigne d'abord l'adresse du site, le nom d'utilisateur et le mot de passe d'application dans l'onglet PROJET pour pouvoir ajouter des images.");
    return null;
  }

  try {
    const authHeader = basicAuthHeader(username, appPassword);
    const bytes = new Uint8Array(await file.arrayBuffer());
    const { mediaId, url } = await uploadImage(siteUrl, authHeader, file.name, bytes);
    return { url, mediaId, filename: file.name, siteUrl };
  } catch (e) {
    alert(`Échec de l'envoi de l'image vers WordPress : ${e.message}`);
    return null;
  }
}

document.getElementById('publish-btn').onclick = async () => {
  const slug = data.project_slug || currentSlug || 'destination';
  const siteUrl = (data.project_site_url || '').replace(/\/+$/, '');
  const username = data.project_wp_username || '';
  const appPassword = data.project_wp_app_password || '';
  const statusEl = document.getElementById('export-status');

  if (!siteUrl || !username || !appPassword) {
    statusEl.textContent = 'Renseigne l\'adresse du site, le nom d\'utilisateur et le mot de passe d\'application dans l\'onglet PROJET.';
    return;
  }

  const authHeader = basicAuthHeader(username, appPassword);

  try {
    statusEl.textContent = 'Recherche de la page...';
    let pageId = await findPageId(siteUrl, slug, authHeader);
    if (!pageId) {
      statusEl.textContent = 'Aucune page existante — création en cours...';
      pageId = await createPage(siteUrl, slug, authHeader);
    }

    const acfPayload = Object.fromEntries(
      ALL_FIELDS.filter(x => x.type !== IMAGE && !x.name.startsWith('project_')).map(x => [x.name, data[x.name] || ''])
    );

    // Les images ont déjà été envoyées dans la médiathèque au moment où elles
    // ont été ajoutées. Si elles pointent vers le site qu'on publie
    // maintenant, on réutilise directement leur ID média — sinon (image
    // ajoutée pour un autre site, cas d'une destination dupliquée) on la
    // retéléverse ici, à partir de son URL d'origine.
    const imageFieldNames = Object.keys(images);
    let imgDone = 0;
    for (const fieldName of imageFieldNames) {
      const img = images[fieldName];
      imgDone++;
      if (img.siteUrl === siteUrl && img.mediaId) {
        acfPayload[fieldName] = img.mediaId;
        continue;
      }
      statusEl.textContent = `Envoi des images (${imgDone}/${imageFieldNames.length})...`;
      const res = await fetch(img.url);
      const bytes = new Uint8Array(await res.arrayBuffer());
      const { mediaId } = await uploadImage(siteUrl, authHeader, img.filename, bytes);
      acfPayload[fieldName] = mediaId;
    }

    statusEl.textContent = 'Enregistrement des textes...';
    await wpFetch(siteUrl, `/wp-json/wp/v2/pages/${pageId}`, authHeader, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ acf: acfPayload }),
    });

    statusEl.textContent = `Publié avec succès (page #${pageId}) — ${Object.keys(acfPayload).length} champ(s) mis à jour.`;
  } catch (e) {
    statusEl.textContent = `Erreur : ${e.message}`;
  }
};

/* ---------------- Mode d'emploi (volet repliable) ---------------- */

function esc(str) {
  return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function renderGuidePanel() {
  const body = document.getElementById('guide-body');
  if (!body) return;

  const slug = data.project_slug || currentSlug || 'destination';
  const siteUrl = data.project_site_url || '(à compléter dans l\'onglet PROJET)';
  const sshHost = data.project_ssh_host || '(à compléter)';
  const sshUser = data.project_ssh_user || '(à compléter)';
  const wpRoot = data.project_wp_root || '~/sites/xxxxx/';
  const imgMap = buildImagesMap(slug);
  const imgCount = Object.keys(imgMap).length;
  const ready = !!(data.project_site_url && data.project_wp_username && data.project_wp_app_password);

  body.innerHTML = `
    <div class="guide-step">
      <div class="guide-step-num">0</div>
      <div class="guide-step-body">
        <h4>Prérequis (une seule fois par site)</h4>
        <ol>
          <li>Installer le plugin <strong>Advanced Custom Fields</strong> (gratuit) :
          Extensions &gt; Ajouter, rechercher "Advanced Custom Fields", Installer puis
          Activer. À sauter si déjà présent sur ce site.</li>
          <li>Déposer le fichier de template sur le serveur (SFTP, une seule fois par
          site) : <a href="../page-landing-guide.php" download class="guide-download">télécharger page-landing-guide.php</a>,
          puis le déposer dans <code>wp-content/themes/genesis-sample/</code> (le thème
          utilisé sur tous nos sites). Sans ce fichier, WordPress refuse le modèle de
          page "Landing Guide" et "Publier en ligne" échoue avec l'erreur
          <em>Paramètre(s) invalide(s) : « template »</em>. À sauter si le template a
          déjà servi sur ce site.</li>
          <li>Importer le groupe de champs :
          <a href="../acf-landing-guide.json" download class="guide-download">télécharger acf-landing-guide.json</a>,
          puis dans WordPress, ACF &gt; Outils &gt; Importer un JSON &gt; "Choisir un
          fichier" &gt; sélectionner le fichier téléchargé &gt; "Importer un JSON".
          Vérifier que "Afficher dans l'API REST" est activé sur ce groupe (déjà
          coché si le fichier fourni est utilisé tel quel). À sauter si le template
          a déjà servi sur ce site.</li>
          <li>Générer un mot de passe d'application : dans WordPress, Utilisateurs &gt;
          Votre profil &gt; tout en bas, section "Mots de passe d'application". Donner
          un nom, cliquer "Ajouter", copier le mot de passe.</li>
        </ol>
        <p class="guide-note">Une fois le template déposé sur le site, pas besoin de
        créer la page vous-même : "Publier en ligne" la crée automatiquement (titre et
        modèle Landing Guide) si elle n'existe pas encore pour cette destination.</p>
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">1</div>
      <div class="guide-step-body">
        <h4>Personnaliser le contenu</h4>
        <p>Parcourir les onglets à gauche (HERO, PIVOT, ... FOOTER) et adapter chaque
        champ à la destination "<strong>${esc(slug)}</strong>". Le contenu est pré-rempli
        avec le texte de Tenerife — à réécrire au fur et à mesure.</p>
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">2</div>
      <div class="guide-step-body">
        <h4>Ajouter les images</h4>
        <p>Dans chaque champ image, choisir un fichier local — il est envoyé
        immédiatement dans la médiathèque WordPress du site, et seul le lien est
        conservé (rien de lourd stocké dans l'éditeur). ${imgCount} image(s)
        ajoutée(s) pour l'instant.</p>
        <p class="guide-note">Nécessite d'avoir déjà renseigné l'adresse du site,
        le nom d'utilisateur et le mot de passe d'application dans l'onglet PROJET
        (section "Publier en un clic") — sinon un message le rappelle à l'ajout
        d'une image.</p>
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">3</div>
      <div class="guide-step-body">
        <h4>Publier</h4>
        ${ready ? `
        <p>Onglet PROJET rempli — cliquer sur le bouton vert <strong>"Publier en
        ligne"</strong> en haut de l'écran. Le contenu et les images sont envoyés
        directement vers <strong>${esc(siteUrl)}</strong>.</p>
        ` : `
        <p>Renseigner dans l'onglet PROJET : l'adresse du site, le nom d'utilisateur
        et le mot de passe d'application (voir prérequis ci-dessus), puis cliquer sur
        <strong>"Publier en ligne"</strong>.</p>
        <p class="guide-note">En cas de blocage (site non compatible, pas d'accès
        admin...) : bouton "Télécharger le ZIP" en secours — à transmettre à un
        développeur avec les identifiants SSH ci-dessous.</p>
        <ol>
          <li>Décompresser <code>livraison-${esc(slug)}.zip</code></li>
          <li>Déposer via SFTP les images dans
          <code>wp-content/themes/genesis-sample/assets/</code>, et
          <code>populate-${esc(slug)}.php</code> à la racine WordPress
          (<code>${esc(wpRoot)}</code>)</li>
          <li>Connexion SSH :<br><code>ssh ${esc(sshUser)}@${esc(sshHost)}</code></li>
          <li>Exécution :<br><code>cd ${esc(wpRoot)}<br>wp eval-file populate-${esc(slug)}.php</code></li>
        </ol>
        `}
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">4</div>
      <div class="guide-step-body">
        <h4>Configurer le CTA de vente</h4>
        <p>Créer le produit sur SendOwl, puis renseigner <strong>cta_price</strong> et
        <strong>cta_url</strong> (onglet CTA FINAL) avec l'URL de paiement — avant ou
        après publication, ça reste modifiable.</p>
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">5</div>
      <div class="guide-step-body">
        <h4>Traduire avec WPML (si site multilingue)</h4>
        <ol>
          <li>WPML &gt; Réglages &gt; Traduction de champs personnalisés : vérifier que
          <strong>cta_url</strong> est en "Traduire" (une URL SendOwl par langue).</li>
          <li>Tous les champs image (couverture, pivot, feuilletage, mockup, portrait,
          logo du site...) doivent rester en <strong>"Copier"</strong> (réglage par
          défaut) — ne pas les passer en "Traduire". Le template résout lui-même la
          bonne variante par langue via la <strong>traduction de médias</strong> de
          WPML : ouvrir l'image dans Médias, la traduire pour chaque langue depuis
          l'onglet de traduction WPML de la pièce jointe. Le champ ACF garde une
          seule référence (l'image FR), mais le site affichera automatiquement la
          traduction du média correspondant à la langue de la page consultée.</li>
          <li>Pages &gt; cliquer sur le crayon sous chaque langue, une par une — jamais
          la traduction automatique en masse.</li>
          <li>Si un champ texte n'apparaît pas dans l'éditeur de traduction : ouvrir
          directement la page traduite dans l'éditeur WordPress standard, tous les
          champs ACF s'y affichent normalement.</li>
        </ol>
      </div>
    </div>

    <div class="guide-step">
      <div class="guide-step-num">✓</div>
      <div class="guide-step-body">
        <h4>Checklist finale</h4>
        <ul class="guide-checklist">
          <li><label><input type="checkbox"> Contenu relu, aucun texte oublié</label></li>
          <li><label><input type="checkbox"> Toutes les images s'affichent</label></li>
          <li><label><input type="checkbox"> cta_price et cta_url corrects par langue</label></li>
          <li><label><input type="checkbox"> Boutons "Obtenir le guide" (nav + hero + CTA) renvoient vers SendOwl</label></li>
          <li><label><input type="checkbox"> Liens CGV / Mentions légales / Contact fonctionnels</label></li>
          <li><label><input type="checkbox"> Cache WP Engine purgé</label></li>
        </ul>
      </div>
    </div>
  `;
}

document.getElementById('guide-toggle').onclick = () => {
  document.getElementById('guide-panel').classList.toggle('open');
};
document.getElementById('guide-close').onclick = () => {
  document.getElementById('guide-panel').classList.remove('open');
};

/* ---------------- Init ---------------- */

(async function init() {
  try {
    const list = await fetchProjectList();
    projectSlugs = list.map(p => p.slug);
  } catch (e) {
    console.error(e);
    setSyncStatus('Impossible de contacter le serveur — voir la console');
  }
  if (projectSlugs.length === 0) projectSlugs = ['tenerife'];
  await loadProject(projectSlugs[0]);
})();
