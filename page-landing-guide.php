<?php
/**
 * Template Name: Landing Guide
 * Template Post Type: page
 */

/**
 * Normalise un champ ACF image quel que soit ce que retourne get_field() :
 * - tableau ACF standard ['url', 'alt', ...]
 * - ID d'attachement (int ou string) — cas fréquent quand WPML copie le champ
 * - URL directe (string)
 */
function rl_get_image( string $field_name ): ?array {
	$img = get_field( $field_name );
	if ( ! $img ) return null;
	if ( is_array( $img ) ) return $img;
	if ( is_numeric( $img ) ) {
		$url = wp_get_attachment_url( (int) $img );
		$alt = get_post_meta( (int) $img, '_wp_attachment_image_alt', true );
		return $url ? [ 'url' => $url, 'alt' => (string) $alt ] : null;
	}
	return [ 'url' => (string) $img, 'alt' => '' ];
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600&family=Meow+Script&display=swap" rel="stylesheet">
<style>
  :root {
    --navy:       #191E55;
    --navy-mid:   #21277a;
    --navy-light: #2d3490;
    --yellow:     #B68207;
    --yellow-mid: #8a6200;
    --yellow-deep: #5a4000;
    --white:      #FFFFFF;
    --grey:       #CCD3DD;
    --grey-text:  #4a5168;
    --off-white:  #f7f6f1;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    background: var(--white);
    color: var(--navy);
    overflow-x: hidden;
  }

  /* ============================
     NAV
  ============================ */
  nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 44px;
    background: rgba(25, 30, 85, 0.97);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
  }

  .nav-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
  }

  .nav-logo-img {
    height: 44px;
    width: auto;
    max-width: min(340px, 82vw);
    display: block;
    mix-blend-mode: screen;
  }

  .nav-cta {
    background: var(--yellow);
    color: var(--navy);
    padding: 10px 22px;
    border-radius: 50px;
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    transition: background 0.2s, transform 0.2s;
  }

  .nav-cta:hover {
    background: var(--yellow-mid);
    color: var(--white);
    transform: translateY(-1px);
  }

  /* ============================
     HERO
  ============================ */
  .hero {
    min-height: 100vh;
    background: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 110px 40px 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  /* Grain texture overlay */
  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.03;
    pointer-events: none;
  }

  /* Halo doré — même intensité que la section pivot */
  .hero-glow {
    position: absolute;
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(249, 213, 99, 0.11) 0%, transparent 68%);
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    pointer-events: none;
    z-index: 0;
  }

  /* Cover mockup */
  .cover-wrap {
    position: relative;
    z-index: 2;
    margin-bottom: 48px;
    animation: floatY 5s ease-in-out infinite;
  }

  @keyframes floatY {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-14px); }
  }

  .cover-card {
    width: 240px;
    background: var(--navy-mid);
    border-radius: 14px;
    overflow: hidden;
    box-shadow:
      0 4px 0 rgba(255,255,255,0.05) inset,
      0 0 0 1px rgba(255,255,255,0.09),
      0 20px 50px rgba(0, 0, 0, 0.42),
      0 0 36px rgba(182, 130, 7, 0.45),
      0 0 72px rgba(249, 213, 99, 0.22),
      0 0 120px rgba(182, 130, 7, 0.12);
  }

  /* Largeur fixe sur la carte ; hauteur = proportion réelle du PNG (pas de crop forcé) */
  .cover-visual {
    width: 100%;
    background: var(--navy);
    position: relative;
    overflow: hidden;
    line-height: 0;
  }

  .cover-visual img {
    width: 100%;
    height: auto;
    display: block;
  }

  .cover-badge {
    position: absolute;
    top: -12px;
    right: -16px;
    background: var(--yellow);
    color: var(--navy);
    font-family: 'Raleway', sans-serif;
    font-size: 10px;
    font-weight: 800;
    padding: 5px 10px;
    border-radius: 50px;
    white-space: nowrap;
    box-shadow: 0 4px 14px rgba(249,213,99,0.4);
  }

  /* Hero text */
  .hero-kicker {
    font-family: 'Meow Script', cursive;
    font-size: 22px;
    color: var(--yellow);
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 0.3s forwards;
  }

  .hero-title {
    font-family: 'Raleway', sans-serif;
    font-weight: 900;
    color: var(--white);
    line-height: 1.12;
    letter-spacing: -0.01em;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 0.5s forwards;
  }

  .hero-title .dest {
    display: block;
    font-size: clamp(28px, 4.8vw, 54px);
    line-height: 1.05;
    letter-spacing: 0.02em;
    text-transform: uppercase;
  }

  .hero-title em {
    display: block;
    font-style: italic;
    color: var(--yellow);
    text-transform: none;
    font-family: 'Raleway', sans-serif;
    font-size: clamp(18px, 2.35vw, 28px);
    font-weight: 700;
    margin-top: 6px;
    line-height: 1.28;
    letter-spacing: -0.01em;
  }

  .hero-subtitle {
    font-size: clamp(15px, 1.8vw, 18px);
    color: rgba(255,255,255,0.88);
    max-width: 500px;
    line-height: 1.75;
    font-weight: 400;
    margin: 0 auto 40px;
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 0.7s forwards;
  }

  .hero-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 0.9s forwards;
  }

  .btn-primary {
    background: var(--yellow);
    color: var(--navy);
    padding: 15px 34px;
    border-radius: 50px;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
  }

  .btn-primary:hover {
    background: var(--yellow-mid);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(182,130,7,0.4);
  }

  .btn-ghost {
    border: 1.5px solid rgba(255,255,255,0.28);
    color: rgba(255,255,255,0.82);
    padding: 15px 28px;
    border-radius: 50px;
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    transition: border-color 0.2s, color 0.2s;
  }

  .btn-ghost:hover {
    border-color: rgba(255,255,255,0.5);
    color: var(--white);
  }

  /* Hero stats */
  .hero-stats {
    display: flex;
    gap: 0;
    margin-top: 60px;
    padding-top: 36px;
    border-top: 1px solid rgba(255,255,255,0.08);
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 1.1s forwards;
    flex-wrap: wrap;
    justify-content: center;
  }

  .stat-item {
    padding: 0 32px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.08);
  }

  .stat-item:last-child { border-right: none; }

  .stat-num {
    font-family: 'Raleway', sans-serif;
    font-weight: 900;
    font-size: 30px;
    color: var(--yellow);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 12px;
    color: rgba(255,255,255,0.62);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 500;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* ============================
     SECTION HELPERS
  ============================ */
  .section-tag {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 22px;
  }

  .tag-yellow {
    background: var(--yellow);
    color: var(--navy);
  }

  .tag-navy-outline {
    border: 1.5px solid rgba(25,30,85,0.2);
    color: var(--navy);
  }

  .tag-white-outline {
    border: 1.5px solid rgba(255,255,255,0.28);
    color: rgba(255,255,255,0.88);
  }

  .section-title {
    font-family: 'Raleway', sans-serif;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: -0.01em;
    line-height: 1.1;
  }

  .section-title-lg {
    font-size: clamp(26px, 4vw, 48px);
  }

  .section-title-md {
    font-size: clamp(22px, 3vw, 38px);
  }

  .section-title .title-accent-gold {
    color: var(--yellow);
  }

  /* Séparateur hero → pivot (même bleu #191E55) */
  .navy-stack-divider {
    background: var(--navy);
    padding: 18px 40px 22px;
    position: relative;
    z-index: 1;
  }

  .navy-stack-divider__line {
    position: relative;
    max-width: 520px;
    margin: 0 auto;
    height: 1px;
    background: linear-gradient(
      90deg,
      transparent 0%,
      rgba(182, 130, 7, 0.2) 18%,
      rgba(249, 213, 99, 0.55) 50%,
      rgba(182, 130, 7, 0.2) 82%,
      transparent 100%
    );
  }

  .navy-stack-divider__gem {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    width: 8px;
    height: 8px;
    background: linear-gradient(145deg, var(--yellow-mid), var(--yellow));
    border-radius: 1px;
    box-shadow:
      0 0 0 5px var(--navy),
      0 2px 20px rgba(182, 130, 7, 0.35);
  }

  /* ============================
     PIVOT (La différence)
  ============================ */
  .pivot {
    background: var(--navy);
    padding: 48px 40px 100px;
    position: relative;
    overflow: hidden;
  }

  .pivot::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.03;
    pointer-events: none;
    z-index: 0;
  }

  .pivot-glow {
    position: absolute;
    width: 520px;
    height: 520px;
    background: radial-gradient(circle, rgba(249, 213, 99, 0.11) 0%, transparent 68%);
    bottom: -140px;
    right: -90px;
    pointer-events: none;
    z-index: 0;
  }

  .pivot-inner {
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
    position: relative;
    z-index: 1;
  }

  .pivot-lede {
    font-family: 'Inter', sans-serif;
    font-size: clamp(14px, 1.5vw, 16px);
    font-style: italic;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.78);
    margin-bottom: 14px;
    letter-spacing: 0.02em;
  }

  .pivot-title {
    color: var(--white);
    margin-bottom: 22px;
    line-height: 1.08;
  }

  .pivot-title span { color: var(--yellow); }

  .pivot-body {
    font-size: 16px;
    color: rgba(255,255,255,0.8);
    line-height: 1.8;
    font-weight: 300;
    margin-bottom: 28px;
  }

  .pivot-quote {
    background: rgba(255, 255, 255, 0.07);
    border-left: 3px solid var(--yellow);
    padding: 18px 22px;
    border-radius: 8px;
  }

  .pivot-quote p {
    font-size: 15px;
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
    font-style: italic;
    font-family: 'Inter', sans-serif;
  }

  .pivot-quote cite {
    display: block;
    font-size: 12px;
    color: var(--yellow);
    font-style: normal;
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-top: 10px;
  }

  /* Mockup stack — extraits réels du guide */
  .pages-stack {
    position: relative;
    height: 400px;
  }

  .page-mock {
    position: absolute;
    width: 200px;
    height: 310px;
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
  }

  .page-mock-1 { left: 0; top: 40px; transform: rotate(-4deg); z-index: 1; }
  .page-mock-2 { left: 78px; top: 0; z-index: 3; }
  .page-mock-3 { left: 156px; top: 50px; transform: rotate(4deg); z-index: 1; }

  .page-mock-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    display: block;
  }

  /* ============================
     FEUILLETAGE VISUEL
  ============================ */
  .feuilletage {
    background: var(--off-white);
    padding: 100px 40px;
    overflow: hidden;
  }

  .feuilletage-inner {
    max-width: 1000px;
    margin: 0 auto;
  }

  .feuilletage-intro {
    font-size: clamp(15px, 1.5vw, 17px);
    color: var(--navy);
    font-weight: 400;
    max-width: 540px;
    line-height: 1.75;
    margin-bottom: 48px;
  }

  .inspi-intro {
    font-size: clamp(15px, 1.5vw, 17px);
    color: var(--grey-text);
    max-width: 500px;
    font-weight: 400;
    line-height: 1.75;
    margin: 0;
  }

  .feuilletage-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }

  .feuillet-card {
    background: var(--white);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(25,30,85,0.1);
  }

  .feuillet-thumb {
    margin: 0;
    line-height: 0;
    background: var(--white);
  }

  .feuillet-card img {
    width: 100%;
    height: auto;
    display: block;
  }

  /* ============================
     BENEFITS TABLE
  ============================ */
  .benefits {
    background: var(--navy);
    padding: 100px 40px;
  }

  .benefits-inner {
    max-width: 860px;
    margin: 0 auto;
  }

  .benefits-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 50px;
  }

  .benefits-table thead th {
    padding: 12px 24px;
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }

  .benefits-table thead th:first-child {
    color: rgba(255,255,255,0.55);
    text-align: left;
    width: 42%;
  }

  .benefits-table thead th:last-child {
    color: var(--yellow);
    text-align: left;
  }

  .benefits-table tbody tr {
    border-top: 1px solid rgba(255,255,255,0.07);
    transition: background 0.2s;
  }

  .benefits-table tbody tr:hover {
    background: rgba(255,255,255,0.03);
  }

  .benefits-table tbody td {
    padding: 18px 24px;
    vertical-align: middle;
  }

  .benefits-table tbody td:first-child {
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  .feat-pill {
    display: inline-block;
    background: rgba(249,213,99,0.12);
    color: var(--yellow);
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: 50px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  .benefits-table .feat-pill {
    display: inline-flex;
    align-items: baseline;
    gap: 0.35em;
    flex-wrap: wrap;
    padding: 10px 16px 10px 14px;
    font-size: 11px;
  }

  .benefits-table .feat-pill__num {
    font-size: clamp(22px, 3.2vw, 30px);
    font-weight: 900;
    line-height: 1;
    letter-spacing: -0.02em;
    text-transform: none;
    font-variant-numeric: tabular-nums;
  }

  .benefits-table tbody td:last-child {
    color: rgba(255,255,255,0.92);
    font-size: 16px;
    font-weight: 400;
    line-height: 1.65;
  }

  /* ============================
     INSPIRATION
  ============================ */
  .inspiration {
    background: var(--white);
    padding: 100px 40px;
  }

  .inspiration-inner { max-width: 1180px; margin: 0 auto; }

  /* 6 cartes en 2 colonnes + mockup smartphone en 3e colonne */
  .inspi-layout {
    display: grid;
    grid-template-columns: 1fr 1fr minmax(160px, 240px);
    gap: 24px 28px;
    margin-top: 50px;
    align-items: center;
  }

  .inspi-cards {
    grid-column: 1 / 3;
  }

  .inspi-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .inspi-preview {
    margin: 0;
    justify-self: center;
    align-self: center;
  }

  .inspi-preview--phone {
    max-width: 220px;
    width: 100%;
    background: transparent;
    border: none;
    padding: 4px 6px 12px;
    overflow: visible;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .inspi-preview__tilt {
    transform: rotate(-6deg);
    transform-origin: 50% 55%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
    filter:
      drop-shadow(0 10px 20px rgba(25, 30, 85, 0.12))
      drop-shadow(0 3px 8px rgba(25, 30, 85, 0.08));
  }

  /* Hauteur plafonnée pour s’aligner visuellement sur le bloc des 6 cartes */
  .inspi-preview--phone img {
    width: auto;
    max-width: min(200px, 100%);
    max-height: clamp(280px, 31vw, 350px);
    height: auto;
    display: block;
    object-fit: contain;
    margin: 0 auto;
  }

  @media (hover: hover) {
    .inspi-preview--phone:hover .inspi-preview__tilt {
      transform: rotate(-4deg) translateY(-2px);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .inspi-preview__tilt {
      transform: rotate(-3deg);
    }
    .inspi-preview--phone:hover .inspi-preview__tilt {
      transform: rotate(-3deg);
    }
  }

  .inspi-card {
    background: var(--off-white);
    border-radius: 14px;
    padding: 22px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: default;
    border: 1px solid rgba(25,30,85,0.05);
  }

  .inspi-emoji { font-size: 28px; flex-shrink: 0; line-height: 1; }

  .inspi-text strong {
    display: block;
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 3px;
  }

  .inspi-text span {
    font-size: 13px;
    color: var(--grey-text);
    font-weight: 400;
    line-height: 1.45;
  }

  /* ============================
     SOCIAL PROOF
  ============================ */
  .proof {
    background: var(--navy);
    padding: 100px 40px;
  }

  .proof-inner { max-width: 900px; margin: 0 auto; }

  .proof-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    margin-top: 50px;
    margin-bottom: 60px;
    background: rgba(255,255,255,0.06);
    border-radius: 16px;
    overflow: hidden;
  }

  .proof-stat {
    padding: 40px 24px;
    text-align: center;
    background: rgba(255,255,255,0.03);
  }

  .proof-stat-num {
    font-family: 'Raleway', sans-serif;
    font-size: 46px;
    font-weight: 900;
    color: var(--yellow);
    line-height: 1;
    margin-bottom: 10px;
  }

  .proof-stat-label {
    font-size: 12px;
    color: rgba(255,255,255,0.68);
    font-weight: 400;
    line-height: 1.5;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-family: 'Raleway', sans-serif;
  }

  .reviews-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
  }

  .review-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    padding: 24px;
  }

  .review-stars {
    color: var(--yellow);
    font-size: 13px;
    letter-spacing: 2px;
    margin-bottom: 12px;
  }

  .review-text {
    font-size: 15px;
    color: rgba(255,255,255,0.92);
    line-height: 1.65;
    font-weight: 400;
    font-style: italic;
    margin-bottom: 16px;
  }

  .review-author {
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 800;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .review-origin {
    font-size: 11px;
    color: rgba(255,255,255,0.35);
    font-weight: 300;
    margin-top: 2px;
  }

  /* ============================
     CTA FINAL
  ============================ */
  .cta-final {
    background: var(--navy);
    padding: 120px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .cta-glow {
    position: absolute;
    width: 800px;
    height: 800px;
    background: radial-gradient(circle, rgba(249,213,99,0.07) 0%, transparent 65%);
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
  }

  .cta-inner {
    position: relative;
    z-index: 2;
    max-width: 600px;
    margin: 0 auto;
  }

  .cta-title {
    font-family: 'Raleway', sans-serif;
    font-size: clamp(30px, 5vw, 60px);
    font-weight: 900;
    color: var(--white);
    text-transform: uppercase;
    line-height: 1.05;
    margin-bottom: 18px;
  }

  .cta-title em {
    font-style: italic;
    color: var(--yellow);
    text-transform: none;
    font-family: 'Meow Script', cursive;
    font-size: 0.95em;
    line-height: 1.3;
  }

  .cta-body {
    font-size: 17px;
    color: rgba(255,255,255,0.86);
    line-height: 1.75;
    font-weight: 400;
    margin-bottom: 50px;
  }

  .price-box {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 36px 44px;
    display: inline-block;
    min-width: 320px;
    margin-bottom: 28px;
  }

  .price-label {
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.58);
    margin-bottom: 12px;
  }

  .price-amount {
    font-family: 'Raleway', sans-serif;
    font-size: 58px;
    font-weight: 900;
    color: var(--white);
    line-height: 1;
    margin-bottom: 8px;
  }

  .price-amount sup {
    font-size: 22px;
    vertical-align: super;
  }

  .price-note {
    font-size: 14px;
    color: rgba(255,255,255,0.62);
    font-weight: 300;
    margin-bottom: 24px;
  }

  .payment-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 18px;
    flex-wrap: wrap;
  }

  .payment-logos img {
    height: 26px;
    width: auto;
    border-radius: 4px;
    opacity: 0.88;
  }

  .cta-reassurances {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
  }

  .reassure-row {
    display: flex;
    justify-content: center;
    gap: 28px;
    flex-wrap: wrap;
  }

  .reassure-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 14px;
    color: rgba(255,255,255,0.72);
  }

  .reassure-item strong {
    color: rgba(255,255,255,0.92);
    font-weight: 600;
  }

  .reassure-item .check {
    color: var(--yellow);
    font-size: 14px;
    font-weight: 700;
  }

  /* ============================
     ENGAGEMENTS
  ============================ */
  .engagements {
    background: var(--white);
    padding: 100px 40px;
  }

  .engagements-inner {
    max-width: 900px;
    margin: 0 auto;
  }

  .engagements-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 56px;
    align-items: center;
  }

  .eng-portrait {
    margin: 0 0 22px 0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(25,30,85,0.14);
    border: 1px solid rgba(25,30,85,0.06);
    max-width: min(400px, 100%);
  }

  .eng-portrait img {
    width: 100%;
    height: auto;
    display: block;
  }

  .eng-body {
    font-size: 16px;
    color: var(--grey-text);
    line-height: 1.75;
    font-weight: 400;
  }

  .engagements-grid > div:first-child p.eng-body:first-of-type {
    margin-bottom: 24px;
  }

  .eng-signature {
    margin-top: 32px;
    padding-top: 28px;
    border-top: 1px solid var(--grey);
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .eng-sig-name {
    font-family: 'Meow Script', cursive;
    font-size: 26px;
    color: var(--yellow);
    line-height: 1.2;
  }

  .eng-sig-role {
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: var(--grey-text);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 4px;
  }

  .engagements-box {
    background: var(--off-white);
    border-radius: 16px;
    padding: 32px;
    border: 1px solid rgba(25,30,85,0.07);
  }

  .eng-box-label {
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 800;
    color: var(--yellow);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 22px;
    line-height: 1.45;
    max-width: 28em;
  }

  .eng-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .eng-item {
    display: flex;
    gap: 14px;
    align-items: flex-start;
  }

  .eng-num {
    font-family: 'Raleway', sans-serif;
    font-weight: 900;
    font-size: 13px;
    color: var(--yellow);
    flex-shrink: 0;
    margin-top: 1px;
  }

  .eng-txt {
    font-size: 14px;
    color: var(--navy);
    font-weight: 400;
    line-height: 1.55;
  }

  /* ============================
     FOOTER
  ============================ */
  footer {
    background: #0f1235;
    padding: 40px 44px 28px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }

  .footer-inner {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }

  .footer-brand {
    font-family: 'Raleway', sans-serif;
    font-weight: 800;
    font-size: 13px;
    color: rgba(255,255,255,0.7);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
  }

  .footer-contact {
    font-size: 13px;
    color: rgba(255,255,255,0.46);
  }

  .footer-contact a {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
  }

  .footer-contact a:hover {
    color: var(--yellow);
  }

  .footer-links {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
  }

  .footer-links a {
    font-size: 13px;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    transition: color 0.2s;
  }

  .footer-links a:hover {
    color: var(--yellow);
  }

  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 20px;
  }

  .footer-copy {
    font-size: 12px;
    color: rgba(255,255,255,0.32);
  }

  /* ============================
     RESPONSIVE
  ============================ */
  @media (max-width: 1040px) {
    .inspi-layout {
      grid-template-columns: 1fr;
      gap: 36px;
    }
    .inspi-cards { grid-column: auto; }
    .inspi-preview--phone {
      max-width: min(260px, 88%);
      margin-left: auto;
      margin-right: auto;
    }
    .inspi-preview--phone img {
      max-height: min(340px, 52vh);
    }
    .inspi-grid { grid-template-columns: 1fr 1fr; }
  }

  @media (max-width: 800px) {
    nav { padding: 14px 20px; }
    .hero { padding: 90px 20px 24px; }
    .navy-stack-divider { padding: 14px 20px 18px; }
    .stat-item { padding: 0 16px; }
    .pivot-inner { grid-template-columns: 1fr; gap: 40px; }
    .pages-stack { display: none; }
    .feuilletage-grid { grid-template-columns: 1fr; }
    .engagements-grid { grid-template-columns: 1fr; gap: 40px; align-items: stretch; }
    .hero-title .dest { font-size: clamp(26px, 6.2vw, 44px); }
    .proof-stats { grid-template-columns: 1fr; gap: 2px; }
    .reviews-grid { grid-template-columns: 1fr; }
    .inspi-grid { grid-template-columns: 1fr 1fr; }
    .benefits-table thead { display: none; }
    .benefits-table td { display: block; padding: 6px 0; }
    .price-box { min-width: unset; width: 100%; }
    footer { flex-direction: column; text-align: center; }
    section { padding-left: 20px !important; padding-right: 20px !important; }
  }

  @media (max-width: 480px) {
    .inspi-grid { grid-template-columns: 1fr; }
    .hero-title .dest { font-size: 30px; }
  }
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class('landing-no-theme'); ?>>
<?php wp_body_open(); ?>

<!-- NAV -->
<nav>
  <a href="#" class="nav-logo">
    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-canarias-lovers.png' ); ?>" alt="Canarias Lovers" class="nav-logo-img" width="340" height="44" loading="eager" decoding="async">
  </a>
  <a href="<?php the_field('cta_url'); ?>" class="nav-cta"><?php the_field('hero_cta_primary'); ?></a>
</nav>

<!-- HERO -->
<?php
$hero_cover = rl_get_image('hero_cover_image');
?>
<section class="hero">
  <div class="hero-glow"></div>

  <div class="cover-wrap">
    <div class="cover-card">
      <div class="cover-visual">
        <?php if ( $hero_cover ) : ?>
        <img src="<?php echo esc_url( $hero_cover['url'] ); ?>" alt="<?php echo esc_attr( $hero_cover['alt'] ); ?>" width="400" height="560" loading="eager" decoding="async">
        <?php endif; ?>
      </div>
    </div>
    <?php if ( get_field('hero_badge') ) : ?>
    <div class="cover-badge"><?php the_field('hero_badge'); ?></div>
    <?php endif; ?>
  </div>

  <div class="hero-kicker"><?php the_field('hero_kicker'); ?></div>

  <h1 class="hero-title">
    <span class="dest"><?php the_field('hero_title_dest'); ?></span>
    <em><?php the_field('hero_title_em'); ?></em>
  </h1>

  <p class="hero-subtitle">
    <?php the_field('hero_subtitle'); ?>
  </p>

  <div class="hero-actions">
    <a href="<?php the_field('cta_url'); ?>" class="btn-primary"><?php the_field('hero_cta_primary'); ?></a>
    <?php if ( get_field('hero_cta_secondary') ) : ?>
    <a href="#contenu" class="btn-ghost"><?php the_field('hero_cta_secondary'); ?></a>
    <?php endif; ?>
  </div>

  <div class="hero-stats">
    <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
    <?php if ( get_field("hero_stat_{$i}_num") ) : ?>
    <div class="stat-item">
      <div class="stat-num"><?php the_field("hero_stat_{$i}_num"); ?></div>
      <div class="stat-label"><?php the_field("hero_stat_{$i}_label"); ?></div>
    </div>
    <?php endif; ?>
    <?php endfor; ?>
  </div>
</section>

<div class="navy-stack-divider" aria-hidden="true">
  <div class="navy-stack-divider__line"><span class="navy-stack-divider__gem"></span></div>
</div>

<!-- PIVOT -->
<?php
$pivot_img1 = rl_get_image('pivot_image_1');
$pivot_img2 = rl_get_image('pivot_image_2');
$pivot_img3 = rl_get_image('pivot_image_3');
?>
<section class="pivot">
  <div class="pivot-glow"></div>
  <div class="pivot-inner">
    <div>
      <?php if ( get_field('pivot_lede') ) : ?>
      <p class="pivot-lede"><?php the_field('pivot_lede'); ?></p>
      <?php endif; ?>
      <h2 class="section-title section-title-lg pivot-title">
        <?php the_field('pivot_title'); ?>
      </h2>
      <p class="pivot-body">
        <?php the_field('pivot_body'); ?>
      </p>
      <?php if ( get_field('pivot_quote') ) : ?>
      <div class="pivot-quote">
        <p><?php the_field('pivot_quote'); ?></p>
        <cite><?php the_field('pivot_quote_cite'); ?></cite>
      </div>
      <?php endif; ?>
    </div>
    <?php if ( $pivot_img1 || $pivot_img2 || $pivot_img3 ) : ?>
    <div class="pages-stack">
      <?php if ( $pivot_img1 ) : ?>
      <div class="page-mock page-mock-1">
        <img class="page-mock-img" src="<?php echo esc_url( $pivot_img1['url'] ); ?>" alt="<?php echo esc_attr( $pivot_img1['alt'] ); ?>" width="400" height="620" loading="lazy" decoding="async">
      </div>
      <?php endif; ?>
      <?php if ( $pivot_img2 ) : ?>
      <div class="page-mock page-mock-2">
        <img class="page-mock-img" src="<?php echo esc_url( $pivot_img2['url'] ); ?>" alt="<?php echo esc_attr( $pivot_img2['alt'] ); ?>" width="400" height="620" loading="lazy" decoding="async">
      </div>
      <?php endif; ?>
      <?php if ( $pivot_img3 ) : ?>
      <div class="page-mock page-mock-3">
        <img class="page-mock-img" src="<?php echo esc_url( $pivot_img3['url'] ); ?>" alt="<?php echo esc_attr( $pivot_img3['alt'] ); ?>" width="400" height="620" loading="lazy" decoding="async">
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- FEUILLETAGE VISUEL -->
<section class="feuilletage" id="contenu">
  <div class="feuilletage-inner">
    <div class="section-tag tag-navy-outline"><?php the_field('feuilletage_tag'); ?></div>
    <h2 class="section-title section-title-lg" style="margin-bottom: 14px; color: var(--navy);"><?php the_field('feuilletage_title'); ?></h2>
    <?php if ( get_field('feuilletage_intro') ) : ?>
    <p class="feuilletage-intro"><?php the_field('feuilletage_intro'); ?></p>
    <?php endif; ?>

    <div class="feuilletage-grid">
      <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
      <?php $feuillet = rl_get_image("feuilletage_image_{$i}"); ?>
      <?php if ( $feuillet ) : ?>
      <article class="feuillet-card">
        <figure class="feuillet-thumb">
          <img src="<?php echo esc_url( $feuillet['url'] ); ?>" alt="<?php echo esc_attr( $feuillet['alt'] ); ?>" width="560" height="790" loading="lazy" decoding="async">
        </figure>
      </article>
      <?php endif; ?>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- BENEFITS TABLE -->
<section class="benefits">
  <div class="benefits-inner">
    <div class="section-tag tag-white-outline"><?php the_field('benefits_tag'); ?></div>
    <h2 class="section-title section-title-lg" style="color:var(--white);margin-bottom:0;"><?php the_field('benefits_title'); ?></h2>
    <table class="benefits-table">
      <thead>
        <tr>
          <th><?php the_field('benefits_th_1'); ?></th>
          <th><?php the_field('benefits_th_2'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
        <?php if ( get_field("benefit_{$i}_feature") ) : ?>
        <tr>
          <td><span class="feat-pill"><?php the_field("benefit_{$i}_feature"); ?></span></td>
          <td><?php the_field("benefit_{$i}_value"); ?></td>
        </tr>
        <?php endif; ?>
        <?php endfor; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- INSPIRATION -->
<?php $inspi_mockup = rl_get_image('inspi_mockup_image'); ?>
<section class="inspiration">
  <div class="inspiration-inner">
    <div class="section-tag tag-navy-outline"><?php the_field('inspi_tag'); ?></div>
    <h2 class="section-title section-title-lg" style="margin-bottom:12px;"><?php the_field('inspi_title'); ?></h2>
    <?php if ( get_field('inspi_intro') ) : ?>
    <p class="inspi-intro"><?php the_field('inspi_intro'); ?></p>
    <?php endif; ?>
    <div class="inspi-layout">
      <div class="inspi-cards">
        <div class="inspi-grid">
          <?php for ( $i = 1; $i <= 12; $i++ ) : ?>
          <?php if ( get_field("inspi_{$i}_title") ) : ?>
          <div class="inspi-card">
            <?php if ( get_field("inspi_{$i}_emoji") ) : ?>
            <div class="inspi-emoji" aria-hidden="true"><?php the_field("inspi_{$i}_emoji"); ?></div>
            <?php endif; ?>
            <div class="inspi-text">
              <strong><?php the_field("inspi_{$i}_title"); ?></strong>
              <span><?php the_field("inspi_{$i}_desc"); ?></span>
            </div>
          </div>
          <?php endif; ?>
          <?php endfor; ?>
        </div>
      </div>
      <?php if ( $inspi_mockup ) : ?>
      <figure class="inspi-preview inspi-preview--phone">
        <div class="inspi-preview__tilt">
          <img src="<?php echo esc_url( $inspi_mockup['url'] ); ?>" alt="<?php echo esc_attr( $inspi_mockup['alt'] ); ?>" width="682" height="1024" loading="lazy" decoding="async">
        </div>
      </figure>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- SOCIAL PROOF -->
<section class="proof">
  <div class="proof-inner">
    <div class="section-tag tag-white-outline" style="margin-bottom:14px;"><?php the_field('proof_tag'); ?></div>
    <h2 class="section-title section-title-lg" style="color:var(--white);"><?php the_field('proof_title'); ?></h2>
    <div class="proof-stats">
      <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
      <?php if ( get_field("proof_stat_{$i}_num") ) : ?>
      <div class="proof-stat">
        <div class="proof-stat-num"><?php the_field("proof_stat_{$i}_num"); ?></div>
        <div class="proof-stat-label"><?php the_field("proof_stat_{$i}_label"); ?></div>
      </div>
      <?php endif; ?>
      <?php endfor; ?>
    </div>
    <div class="reviews-grid">
      <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
      <?php if ( get_field("review_{$i}_text") ) : ?>
      <div class="review-card">
        <div class="review-stars">★★★★★</div>
        <p class="review-text"><?php the_field("review_{$i}_text"); ?></p>
        <div class="review-author"><?php the_field("review_{$i}_author"); ?></div>
      </div>
      <?php endif; ?>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- TERRAIN & ENGAGEMENTS -->
<?php $eng_portrait = rl_get_image('eng_portrait'); ?>
<section class="engagements">
  <div class="engagements-inner">
    <div class="engagements-grid">

      <div>
        <?php if ( $eng_portrait ) : ?>
        <figure class="eng-portrait">
          <img src="<?php echo esc_url( $eng_portrait['url'] ); ?>" alt="<?php echo esc_attr( $eng_portrait['alt'] ); ?>" width="520" height="340" loading="lazy" decoding="async">
        </figure>
        <?php endif; ?>
        <div class="section-tag tag-navy-outline"><?php the_field('eng_tag'); ?></div>
        <h2 class="section-title section-title-md" style="margin-bottom: 18px; color: var(--navy);">
          <?php the_field('eng_title'); ?>
        </h2>
        <?php if ( get_field('eng_body_1') ) : ?>
        <p class="eng-body">
          <?php the_field('eng_body_1'); ?>
        </p>
        <?php endif; ?>
        <?php if ( get_field('eng_body_2') ) : ?>
        <p class="eng-body">
          <?php the_field('eng_body_2'); ?>
        </p>
        <?php endif; ?>

        <div class="eng-signature">
          <div>
            <div class="eng-sig-name"><?php the_field('eng_sig_name'); ?></div>
            <div class="eng-sig-role"><?php the_field('eng_sig_role'); ?></div>
          </div>
        </div>
      </div>

      <div>
        <div class="engagements-box">
          <div class="eng-box-label"><?php the_field('eng_box_label'); ?></div>
          <div class="eng-list">
            <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
            <?php if ( get_field("eng_item_{$i}") ) : ?>
            <div class="eng-item">
              <span class="eng-num"><?php echo str_pad( $i, 2, '0', STR_PAD_LEFT ); ?></span>
              <span class="eng-txt"><?php the_field("eng_item_{$i}"); ?></span>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final" id="acheter">
  <div class="cta-glow"></div>
  <div class="cta-inner">
    <?php if ( get_field('cta_tag') ) : ?>
    <div class="section-tag tag-white-outline" style="margin-bottom:20px;"><?php the_field('cta_tag'); ?></div>
    <?php endif; ?>
    <h2 class="cta-title">
      <?php the_field('cta_title'); ?><br>
      <em><?php the_field('cta_title_em'); ?></em>
    </h2>
    <?php if ( get_field('cta_body') ) : ?>
    <p class="cta-body">
      <?php the_field('cta_body'); ?>
    </p>
    <?php endif; ?>
    <div class="price-box">
      <?php if ( get_field('cta_price_label') ) : ?>
      <div class="price-label"><?php the_field('cta_price_label'); ?></div>
      <?php endif; ?>
      <div class="price-amount"><sup>€</sup><?php the_field('cta_price'); ?></div>
      <?php if ( get_field('cta_price_note') ) : ?>
      <div class="price-note"><?php the_field('cta_price_note'); ?></div>
      <?php endif; ?>
      <a href="<?php the_field('cta_url'); ?>" class="btn-primary" style="width:100%;justify-content:center;font-size:15px;padding:17px;">
        <?php the_field('cta_btn_label'); ?>
      </a>
      <div class="payment-logos">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-payment-amex.png' ); ?>" alt="American Express" width="40" height="26" loading="lazy" decoding="async">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-payment-mastercard.png' ); ?>" alt="Mastercard" width="40" height="26" loading="lazy" decoding="async">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-payment-paypal.png' ); ?>" alt="PayPal" width="68" height="26" loading="lazy" decoding="async">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-payment-visa.png' ); ?>" alt="Visa" width="50" height="26" loading="lazy" decoding="async">
      </div>
    </div>
    <div class="cta-reassurances">
      <div class="reassure-row">
        <?php if ( get_field('cta_reassure_1') ) : ?>
        <div class="reassure-item"><span class="check">✓</span> <strong><?php the_field('cta_reassure_1'); ?></strong></div>
        <?php endif; ?>
        <?php if ( get_field('cta_reassure_2') ) : ?>
        <div class="reassure-item"><span class="check">✓</span> <?php the_field('cta_reassure_2'); ?></div>
        <?php endif; ?>
      </div>
      <div class="reassure-row">
        <?php if ( get_field('cta_reassure_3') ) : ?>
        <div class="reassure-item"><span class="check">✓</span> <?php the_field('cta_reassure_3'); ?></div>
        <?php endif; ?>
        <?php if ( get_field('cta_reassure_4') ) : ?>
        <div class="reassure-item"><span class="check">✓</span> <?php the_field('cta_reassure_4'); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-brand"><?php the_field('footer_brand'); ?></div>
      <?php if ( get_field('footer_contact_url') ) : ?>
      <div class="footer-contact">
        <a href="<?php the_field('footer_contact_url'); ?>"><?php the_field('footer_contact_label'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php if ( get_field('footer_cgv_url') || get_field('footer_legal_url') ) : ?>
    <div class="footer-links">
      <?php if ( get_field('footer_cgv_url') ) : ?>
        <a href="<?php the_field('footer_cgv_url'); ?>"><?php the_field('footer_cgv_label'); ?></a>
      <?php endif; ?>
      <?php if ( get_field('footer_legal_url') ) : ?>
        <a href="<?php the_field('footer_legal_url'); ?>"><?php the_field('footer_legal_label'); ?></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="footer-bottom">
    <div class="footer-copy"><?php the_field('footer_copy'); ?></div>
  </div>
</footer>

<script>
  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.opacity = '1';
        e.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll(
    '.feuillet-card, .inspi-card, .review-card, .proof-stat'
  ).forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(22px)';
    el.style.transition = `opacity 0.5s ease ${i * 0.05}s, transform 0.5s ease ${i * 0.05}s`;
    io.observe(el);
  });
</script>

<?php wp_footer(); ?>
</body>
</html>
