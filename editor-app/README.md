# Éditeur Landing Guide — app Vercel

Petite app Next.js qui protège l'éditeur (`../editor/landing-editor.html`) derrière une
connexion avec un compte **Region Lovers** — même mécanisme que redactorv5 et Visior :
JWT signé côté serveur après validation des identifiants auprès de
`https://api-prod.regionlovers.ai/auth/login`, stocké en `localStorage` côté client
(pas de cookie, pas de next-auth).

Les projets (textes + images de chaque destination) sont stockés dans **MongoDB**
plutôt que dans le navigateur : toute l'équipe travaille sur les mêmes données, depuis
n'importe quel poste, avec reprise du travail là où il a été laissé.

## Développement local

```bash
npm install
cp .env.local.example .env.local
# éditer .env.local : définir JWT_SECRET (openssl rand -hex 32)
# et MONGODB_URI (cluster MongoDB Atlas, offre gratuite suffisante)
npm run dev
```

`npm run dev` et `npm run build` régénèrent automatiquement `public/landing-editor.html`
à partir de `../editor/build.js` — ne pas éditer ce fichier directement dans `public/`,
toujours passer par les fichiers sources dans `../editor/`.

## Déploiement sur Vercel

1. Importer le dépôt dans Vercel.
2. Dans les réglages du projet, définir le **Root Directory** sur `editor-app`.
3. Ajouter les variables d'environnement `JWT_SECRET` et `MONGODB_URI` (Production +
   Preview). Sur MongoDB Atlas, penser à autoriser les IP de Vercel dans "Network
   Access" (ou `0.0.0.0/0` pour simplifier, Vercel utilisant des IP dynamiques).
4. Déployer. Chaque build relance automatiquement `sync-editor` pour embarquer la
   dernière version de l'éditeur.

## Modèle de données MongoDB

Base `landing_guide_editor` (configurable via `MONGODB_DB`), une seule collection
`projects`, un document par destination :

```json
{
  "slug": "loire",
  "data": { "hero_title_dest": "...", "cta_url": "...", ... },
  "images": {
    "hero_cover_image": {
      "url": "https://loirelovers.fr/wp-content/uploads/2026/07/cover-loire.png",
      "mediaId": 482,
      "filename": "cover-loire.png",
      "siteUrl": "https://loirelovers.fr"
    }
  },
  "updatedAt": "2026-07-13T07:52:54.476Z",
  "updatedBy": "manu@regionlovers.fr"
}
```

Les images ne sont jamais stockées dans Mongo : dès qu'un fichier est choisi dans
l'éditeur, il est envoyé directement dans la médiathèque WordPress du site renseigné
dans l'onglet PROJET, et seul le lien (URL + ID média) est conservé. Documents très
légers, pas de limite de taille à surveiller. Si un projet est dupliqué pour un autre
site, "Publier en ligne" retéléverse automatiquement les images qui pointaient vers un
site différent.

## Notes de sécurité

- Il n'existe pas de restriction par email : toute personne avec un compte Region
  Lovers valide peut se connecter. Si besoin de limiter l'accès à une liste précise
  (comme `ADMIN_EMAILS` dans redactorv5), ajouter cette vérification dans
  `app/api/auth/rl-login/route.ts` avant de signer le JWT.
- Le JWT expire après 24h ; l'utilisateur doit alors se reconnecter.
- Aucune limite de tentatives de connexion n'est mise en place (contrairement à
  redactorv5 qui utilise `express-rate-limit`) — à ajouter si nécessaire pour un usage
  public.
