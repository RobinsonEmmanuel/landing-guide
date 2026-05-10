<?php
/**
 * Template Name: Landing Tenerife
 * Template Post Type: page
 */
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
    --grey-text:  #6b7488;
    --off-white:  #f7f6f1;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'Inter', sans-serif;
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
    gap: 10px;
    text-decoration: none;
  }

  /* Logomark SVG inline */
  .nav-logomark { width: 28px; height: 28px; }

  .nav-brand {
    font-family: 'Raleway', sans-serif;
    font-weight: 800;
    font-size: 14px;
    color: var(--white);
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }

  .nav-brand span {
    color: var(--yellow);
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
    padding: 110px 40px 80px;
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

  /* Soft yellow glow */
  .hero-glow {
    position: absolute;
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(249,213,99,0.12) 0%, transparent 70%);
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    pointer-events: none;
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
    width: 190px;
    background: var(--navy-mid);
    border-radius: 14px;
    overflow: hidden;
    box-shadow:
      0 4px 0 rgba(255,255,255,0.04) inset,
      0 40px 80px rgba(0,0,0,0.55),
      0 0 0 1px rgba(255,255,255,0.07);
  }

  .cover-visual {
    height: 150px;
    background: linear-gradient(170deg, #8b6030 0%, #4a2a08 55%, #1a0d04 100%);
    position: relative;
    overflow: hidden;
  }

  .cover-visual svg {
    position: absolute;
    bottom: 0;
    width: 100%;
  }

  .cover-heart-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -52%);
    opacity: 0.18;
  }

  .cover-body {
    padding: 14px 14px 16px;
    text-align: center;
  }

  .cover-title {
    font-family: 'Raleway', sans-serif;
    font-weight: 900;
    font-size: 20px;
    color: var(--white);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 5px;
  }

  .cover-sub {
    font-family: 'Raleway', sans-serif;
    font-size: 7px;
    font-weight: 700;
    color: var(--yellow);
    letter-spacing: 0.14em;
    text-transform: uppercase;
    margin-bottom: 8px;
  }

  .cover-brand {
    font-family: 'Raleway', sans-serif;
    font-size: 7px;
    font-weight: 700;
    color: rgba(255,255,255,0.35);
    letter-spacing: 0.1em;
    text-transform: uppercase;
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
    font-size: clamp(38px, 6.5vw, 76px);
    font-weight: 900;
    color: var(--white);
    line-height: 1.06;
    letter-spacing: -0.01em;
    text-transform: uppercase;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeUp 0.6s ease 0.5s forwards;
  }

  .hero-title em {
    font-style: italic;
    color: var(--yellow);
    text-transform: none;
    font-family: 'Raleway', sans-serif;
  }

  .hero-subtitle {
    font-size: clamp(14px, 1.7vw, 17px);
    color: rgba(255,255,255,0.6);
    max-width: 500px;
    line-height: 1.75;
    font-weight: 300;
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
    border: 1.5px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.65);
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
    font-size: 11px;
    color: rgba(255,255,255,0.4);
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
    border: 1.5px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.7);
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

  /* ============================
     PROBLÈME
  ============================ */
  .problem {
    background: var(--off-white);
    padding: 100px 40px;
    text-align: center;
  }

  .problem-inner { max-width: 680px; margin: 0 auto; }

  .problem-headline {
    font-family: 'Raleway', sans-serif;
    font-size: clamp(20px, 3vw, 34px);
    font-weight: 800;
    color: var(--navy);
    line-height: 1.4;
    margin-bottom: 24px;
  }

  .problem-headline em {
    font-style: italic;
    color: var(--grey-text);
    font-weight: 400;
    font-family: 'Inter', sans-serif;
    text-transform: none;
    font-size: 0.9em;
  }

  .problem-body {
    font-size: 16px;
    color: var(--grey-text);
    line-height: 1.85;
    font-weight: 300;
  }

  .problem-body strong {
    color: var(--navy);
    font-weight: 600;
  }

  /* ============================
     PIVOT
  ============================ */
  .pivot {
    background: var(--navy);
    padding: 100px 40px;
    position: relative;
    overflow: hidden;
  }

  .pivot-glow {
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(249,213,99,0.08) 0%, transparent 70%);
    bottom: -150px;
    right: -100px;
  }

  .pivot-inner {
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
  }

  .pivot-title {
    color: var(--white);
    margin-bottom: 20px;
  }

  .pivot-title span { color: var(--yellow); }

  .pivot-body {
    font-size: 16px;
    color: rgba(255,255,255,0.6);
    line-height: 1.8;
    font-weight: 300;
    margin-bottom: 28px;
  }

  .pivot-quote {
    background: rgba(249,213,99,0.08);
    border-left: 3px solid var(--yellow);
    padding: 18px 22px;
    border-radius: 0 8px 8px 0;
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

  /* Mockup stack */
  .pages-stack {
    position: relative;
    height: 360px;
  }

  .page-mock {
    position: absolute;
    width: 195px;
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
  }

  .page-mock-1 { left: 0; top: 40px; transform: rotate(-4deg); z-index: 1; }
  .page-mock-2 { left: 75px; top: 0; z-index: 3; }
  .page-mock-3 { left: 150px; top: 50px; transform: rotate(4deg); z-index: 1; }

  .pm-header {
    height: 78px;
    position: relative;
    display: flex;
    align-items: flex-end;
    padding: 10px 12px;
  }

  .pm-header h4 {
    color: white;
    font-family: 'Raleway', sans-serif;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    line-height: 1.3;
  }

  .pm-num {
    position: absolute;
    top: 8px; right: 10px;
    width: 20px; height: 20px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    font-weight: 800;
    color: var(--navy);
    font-family: 'Raleway', sans-serif;
  }

  .pm-band {
    height: 13px;
    background: var(--yellow-mid);
    display: flex;
    align-items: center;
    padding: 0 10px;
    gap: 4px;
  }

  .pm-dot {
    width: 5px; height: 5px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
  }

  .pm-body { padding: 10px 12px; }

  .pm-circles {
    display: flex;
    position: relative;
    height: 55px;
    margin-bottom: 8px;
  }

  .pm-c1, .pm-c2 {
    position: absolute;
    border-radius: 50%;
  }

  .pm-c1 { width: 48px; height: 48px; top: 0; left: 4px; }
  .pm-c2 { width: 38px; height: 38px; top: 6px; left: 34px; background: var(--yellow); opacity: 0.75; }

  .pm-lines div {
    height: 5px;
    background: var(--grey);
    border-radius: 3px;
    margin-bottom: 4px;
  }

  .pm-lines div:nth-child(1) { width: 90%; }
  .pm-lines div:nth-child(2) { width: 70%; }
  .pm-lines div:nth-child(3) { width: 80%; }

  .pm-link {
    display: inline-block;
    border: 1px solid var(--grey);
    border-radius: 20px;
    padding: 3px 9px;
    font-size: 7px;
    color: var(--grey-text);
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-top: 5px;
  }

  /* ============================
     FEATURES
  ============================ */
  .features {
    background: var(--off-white);
    padding: 100px 40px;
  }

  .features-inner {
    max-width: 960px;
    margin: 0 auto;
  }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 50px;
  }

  .feature-card {
    background: var(--white);
    border-radius: 16px;
    padding: 28px 28px 28px 24px;
    display: flex;
    gap: 18px;
    align-items: flex-start;
    border: 1px solid rgba(25,30,85,0.06);
    transition: transform 0.25s, box-shadow 0.25s;
  }

  .feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 40px rgba(25,30,85,0.1);
  }

  .feat-icon {
    width: 46px;
    height: 46px;
    background: var(--navy);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
  }

  .feat-content h3 {
    font-family: 'Raleway', sans-serif;
    font-size: 15px;
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 6px;
  }

  .feat-content p {
    font-size: 13.5px;
    color: var(--grey-text);
    line-height: 1.65;
    font-weight: 300;
  }

  .feat-tag {
    display: inline-block;
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 800;
    color: var(--yellow);
    margin-top: 8px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
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
    color: rgba(255,255,255,0.35);
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

  .benefits-table tbody td:last-child {
    color: rgba(255,255,255,0.7);
    font-size: 14px;
    font-weight: 300;
    line-height: 1.65;
  }

  /* ============================
     INSPIRATION
  ============================ */
  .inspiration {
    background: var(--white);
    padding: 100px 40px;
  }

  .inspiration-inner { max-width: 960px; margin: 0 auto; }

  .inspi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 50px;
  }

  .inspi-card {
    background: var(--off-white);
    border-radius: 14px;
    padding: 22px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: default;
    border: 1px solid transparent;
  }

  .inspi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(25,30,85,0.1);
    border-color: var(--yellow);
  }

  .inspi-emoji { font-size: 28px; flex-shrink: 0; }

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
    font-size: 12px;
    color: var(--grey-text);
    font-weight: 300;
    line-height: 1.4;
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
    color: rgba(255,255,255,0.5);
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
    font-size: 13.5px;
    color: rgba(255,255,255,0.7);
    line-height: 1.7;
    font-weight: 300;
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
     PHILOSOPHY
  ============================ */
  .philosophy {
    background: var(--off-white);
    padding: 100px 40px;
  }

  .phil-inner {
    max-width: 880px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
  }

  .phil-title {
    color: var(--navy);
    margin-bottom: 20px;
  }

  .phil-body {
    font-size: 15px;
    color: var(--grey-text);
    line-height: 1.85;
    font-weight: 300;
    margin-bottom: 28px;
  }

  .phil-creds { display: flex; flex-direction: column; gap: 13px; }

  .cred-row {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: var(--navy);
    font-weight: 500;
  }

  .cred-row::before {
    content: '';
    width: 8px;
    height: 8px;
    background: var(--yellow-mid);
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* Phil visual */
  .phil-visual {
    background: var(--navy);
    border-radius: 20px;
    padding: 38px;
    position: relative;
    overflow: hidden;
  }

  .phil-visual::before {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(249,213,99,0.1) 0%, transparent 70%);
    top: -60px;
    right: -60px;
  }

  .phil-quote-text {
    font-family: 'Inter', sans-serif;
    font-size: 17px;
    color: var(--white);
    line-height: 1.6;
    font-style: italic;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
  }

  .phil-quote-text span { color: var(--yellow); }

  .phil-signature {
    font-family: 'Meow Script', cursive;
    font-size: 22px;
    color: var(--yellow);
    position: relative;
    z-index: 1;
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
    font-size: 16px;
    color: rgba(255,255,255,0.55);
    line-height: 1.8;
    font-weight: 300;
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
    color: rgba(255,255,255,0.4);
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
    font-size: 13px;
    color: rgba(255,255,255,0.4);
    font-weight: 300;
    margin-bottom: 24px;
  }

  .cta-reassurances {
    display: flex;
    justify-content: center;
    gap: 22px;
    flex-wrap: wrap;
    margin-top: 18px;
  }

  .reassure-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    color: rgba(255,255,255,0.45);
  }

  .reassure-item .check {
    color: var(--yellow);
    font-size: 14px;
    font-weight: 700;
  }

  /* ============================
     FOOTER
  ============================ */
  footer {
    background: #0f1235;
    padding: 36px 44px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }

  .footer-brand {
    font-family: 'Raleway', sans-serif;
    font-weight: 800;
    font-size: 13px;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .footer-copy {
    font-size: 12px;
    color: rgba(255,255,255,0.2);
  }

  /* ============================
     RESPONSIVE
  ============================ */
  @media (max-width: 800px) {
    nav { padding: 14px 20px; }
    .hero { padding: 90px 20px 60px; }
    .stat-item { padding: 0 16px; }
    .pivot-inner, .phil-inner { grid-template-columns: 1fr; gap: 40px; }
    .pages-stack { display: none; }
    .features-grid { grid-template-columns: 1fr; }
    .proof-stats { grid-template-columns: 1fr; gap: 2px; }
    .reviews-grid { grid-template-columns: 1fr; }
    .inspi-grid { grid-template-columns: 1fr 1fr; }
    .benefits-table thead { display: none; }
    .benefits-table td { display: block; padding: 6px 0; }
    .price-box { min-width: unset; width: 100%; }
    footer { flex-direction: column; text-align: center; }
    section { padding-left: 20px !important; padding-right: 20px !important; }
    /* Engagements responsive */
    section > div > div[style*="grid-template-columns: 1fr 1fr"] {
      grid-template-columns: 1fr !important;
      gap: 40px !important;
    }
  }

  @media (max-width: 480px) {
    .inspi-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 36px; }
  }
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class('landing-no-theme'); ?>>
<?php wp_body_open(); ?>

<!-- NAV -->
<nav>
  <a href="#" class="nav-logo">
    <!-- Logomark Region Lovers / Canarias Lovers (heart + cursive Q) -->
    <svg class="nav-logomark" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 34 C20 34 6 24 6 14 C6 9.5 9.5 6 14 6 C17 6 19.5 7.5 20 10 C20.5 7.5 23 6 26 6 C30.5 6 34 9.5 34 14 C34 24 20 34 20 34Z" fill="none" stroke="#F9D563" stroke-width="1.8"/>
      <path d="M17 34 Q20 36 24 32" stroke="#F9D563" stroke-width="1.5" fill="none" stroke-linecap="round"/>
    </svg>
    <span class="nav-brand">CANARIAS <span>L</span>OVERS</span>
  </a>
  <a href="#acheter" class="nav-cta">Obtenir le guide</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-glow"></div>

  <div class="cover-wrap">
    <div class="cover-card">
      <div class="cover-visual">
        <!-- Volcanic landscape SVG -->
        <svg viewBox="0 0 190 150" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="vsky" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#1a5a88"/>
              <stop offset="60%" stop-color="#7a5020"/>
              <stop offset="100%" stop-color="#3a1a00"/>
            </linearGradient>
            <linearGradient id="vrock" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#9a7020"/>
              <stop offset="100%" stop-color="#3a1a00"/>
            </linearGradient>
          </defs>
          <rect width="190" height="150" fill="url(#vsky)"/>
          <!-- Horizon haze -->
          <ellipse cx="95" cy="55" rx="95" ry="18" fill="rgba(180,120,30,0.18)"/>
          <!-- Main volcano -->
          <polygon points="95,18 135,85 55,85" fill="url(#vrock)"/>
          <!-- Lava floor -->
          <rect x="0" y="85" width="190" height="65" fill="#2a1000"/>
          <!-- Rock left -->
          <polygon points="20,65 42,85 5,85" fill="#6a4010"/>
          <!-- Rock right -->
          <polygon points="155,62 170,85 140,85" fill="#6a4010"/>
          <!-- Small rocks -->
          <ellipse cx="40" cy="87" rx="9" ry="5" fill="#3a1a08"/>
          <ellipse cx="135" cy="89" rx="7" ry="4" fill="#3a1a08"/>
        </svg>
        <!-- Heart overlay -->
        <div class="cover-heart-overlay">
          <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
            <path d="M30 50 C30 50 8 36 8 20 C8 13 14 8 21 8 C25.5 8 29 10.5 30 13 C31 10.5 34.5 8 39 8 C46 8 52 13 52 20 C52 36 30 50 30 50Z" fill="none" stroke="white" stroke-width="1.5"/>
          </svg>
        </div>
      </div>
      <div class="cover-body">
        <div class="cover-title">TENERIFE</div>
        <div class="cover-sub">Choisir · Comprendre · Explorer</div>
        <div class="cover-brand">Éditions Canarias Lovers</div>
      </div>
    </div>
    <div class="cover-badge">+15 000 vendus</div>
  </div>

  <div class="hero-kicker">guide numérique · 161 pages</div>

  <h1 class="hero-title">
    Comprendre Tenerife<br>
    <em>avant même d'y être.</em>
  </h1>

  <p class="hero-subtitle">
    Un guide qui ne cherche pas à tout dire. Il aide à <strong style="color:rgba(255,255,255,0.85)">choisir</strong> — les lieux, les zones, les ambiances — pour construire un voyage qui vous ressemble vraiment.
  </p>

  <div class="hero-actions">
    <a href="#acheter" class="btn-primary">Obtenir le guide →</a>
    <a href="#contenu" class="btn-ghost">Voir le contenu</a>
  </div>

  <div class="hero-stats">
    <div class="stat-item">
      <div class="stat-num">112</div>
      <div class="stat-label">lieux sélectionnés</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">161</div>
      <div class="stat-label">pages</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">14</div>
      <div class="stat-label">zones couvertes</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">6</div>
      <div class="stat-label">pages inspiration</div>
    </div>
  </div>
</section>

<!-- PROBLÈME -->
<section class="problem">
  <div class="problem-inner">
    <div class="section-tag tag-navy-outline">Le problème</div>
    <p class="problem-headline">
      Vous cherchez Tenerife en ligne.<br>
      <em>Vous trouvez 400 articles, 12 000 avis, des listes de "top 10" qui se contredisent.</em>
    </p>
    <p class="problem-body">
      Après deux heures de recherche, vous avez plus d'onglets ouverts que de certitudes. Vous ne savez pas quelle zone correspond à vos envies, quels lieux méritent vraiment le déplacement, ni comment lire l'île dans son ensemble.<br><br>
      Ce n'est pas un problème d'information. <strong>C'est un problème de clarté.</strong>
    </p>
  </div>
</section>

<!-- PIVOT -->
<section class="pivot">
  <div class="pivot-glow"></div>
  <div class="pivot-inner">
    <div>
      <div class="section-tag tag-white-outline">La différence</div>
      <h2 class="section-title section-title-lg pivot-title">
        La plupart des guides<br>
        <span>accumulent.</span><br>
        Le nôtre aide à<br>
        <span>choisir.</span>
      </h2>
      <p class="pivot-body">
        Le guide Tenerife Canarias Lovers n'est pas une base de données. C'est un outil de décision — pensé pour smartphone et tablette — conçu pour vous permettre de comprendre la destination avant de réserver, et de construire un voyage personnel, pas générique.
      </p>
      <div class="pivot-quote">
        <p>"Le guide vous aide à choisir. Le site vous aide à organiser. Une philosophie simple, appliquée à chaque page."</p>
        <cite>— Canarias Lovers</cite>
      </div>
    </div>
    <div class="pages-stack">
      <!-- Mock page 1 : Teide -->
      <div class="page-mock page-mock-1">
        <div class="pm-header" style="background: linear-gradient(180deg, #8B5010 0%, #3a1800 100%);">
          <h4>Parc national<br>du Teide</h4>
          <div class="pm-num">8</div>
        </div>
        <div class="pm-band">
          <div class="pm-dot"></div><div class="pm-dot"></div><div class="pm-dot"></div>
        </div>
        <div class="pm-body">
          <div class="pm-circles">
            <div class="pm-c1" style="background:#c8900a;"></div>
            <div class="pm-c2"></div>
          </div>
          <div class="pm-lines"><div></div><div></div><div></div></div>
          <span class="pm-link">EN SAVOIR PLUS</span>
        </div>
      </div>
      <!-- Mock page 2 : Puerto de la Cruz -->
      <div class="page-mock page-mock-2">
        <div class="pm-header" style="background: linear-gradient(180deg, #1a5a8a 0%, #0a2a50 100%);">
          <h4>Puerto de<br>la Cruz</h4>
          <div class="pm-num">17</div>
        </div>
        <div class="pm-band">
          <div class="pm-dot"></div><div class="pm-dot"></div><div class="pm-dot"></div><div class="pm-dot"></div>
        </div>
        <div class="pm-body">
          <div class="pm-circles">
            <div class="pm-c1" style="background:#3a6a9a;"></div>
            <div class="pm-c2"></div>
          </div>
          <div class="pm-lines"><div></div><div></div><div></div></div>
          <span class="pm-link">HORAIRES & PHOTOS</span>
        </div>
      </div>
      <!-- Mock page 3 : Anaga -->
      <div class="page-mock page-mock-3">
        <div class="pm-header" style="background: linear-gradient(180deg, #2a7a3a 0%, #0a3a1a 100%);">
          <h4>Parc Anaga</h4>
          <div class="pm-num">119</div>
        </div>
        <div class="pm-band">
          <div class="pm-dot"></div><div class="pm-dot"></div>
        </div>
        <div class="pm-body">
          <div class="pm-circles">
            <div class="pm-c1" style="background:#4a8a5a;"></div>
            <div class="pm-c2"></div>
          </div>
          <div class="pm-lines"><div></div><div></div><div></div></div>
          <span class="pm-link">EN SAVOIR PLUS</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="contenu">
  <div class="features-inner">
    <div class="section-tag tag-navy-outline">Ce que contient le guide</div>
    <h2 class="section-title section-title-lg" style="margin-bottom:12px;">Tout ce dont vous avez besoin<br>pour comprendre l'île.</h2>
    <p style="font-size:15px;color:var(--grey-text);max-width:500px;font-weight:300;line-height:1.7;">Une sélection éditoriale rigoureuse, des visuels au cœur de chaque page, une structure qui rend la comparaison immédiate.</p>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feat-icon">📍</div>
        <div class="feat-content">
          <h3>112 lieux sélectionnés</h3>
          <p>Villages, plages, paysages volcaniques, jardins, points de vue, randonnées, expériences familiales. Chaque lieu mérite d'y être.</p>
          <span class="feat-tag">1 lieu = 1 page structurée</span>
        </div>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📸</div>
        <div class="feat-content">
          <h3>~3 photos par lieu</h3>
          <p>Les photos ne sont pas décoratives. Elles permettent de comprendre l'ambiance, de comparer, de se projeter avant de décider.</p>
          <span class="feat-tag">Projection visuelle avant tout</span>
        </div>
      </div>
      <div class="feature-card">
        <div class="feat-icon">🗺️</div>
        <div class="feat-content">
          <h3>Cartes par grande région</h3>
          <p>1 carte générale + 1 carte par cluster géographique. Comprendre les distances réelles et construire des journées cohérentes.</p>
          <span class="feat-tag">14 zones couvertes</span>
        </div>
      </div>
      <div class="feature-card">
        <div class="feat-icon">✨</div>
        <div class="feat-content">
          <h3>6 pages inspiration</h3>
          <p>Volcans, plages, randonnées, jardins, ambiances familiales, architecture. Explorer par envies plutôt que par ordre géographique.</p>
          <span class="feat-tag">Explorer par envies</span>
        </div>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📱</div>
        <div class="feat-content">
          <h3>Pensé pour smartphone</h3>
          <p>Lisibilité, navigation simple, consultation rapide. Un outil qu'on utilise vraiment — dans le canapé, dans l'avion, sur place.</p>
          <span class="feat-tag">Tablette & mobile optimisés</span>
        </div>
      </div>
      <div class="feature-card">
        <div class="feat-icon">🔗</div>
        <div class="feat-content">
          <h3>Connecté au site</h3>
          <p>Chaque lieu renvoie au site pour horaires, prix et conseils pratiques. Le guide choisit, le site organise.</p>
          <span class="feat-tag">Infos pratiques toujours à jour</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BENEFITS TABLE -->
<section class="benefits">
  <div class="benefits-inner">
    <div class="section-tag tag-white-outline">Ce que ça vous apporte</div>
    <h2 class="section-title section-title-lg" style="color:var(--white);margin-bottom:0;">Des features.<br>Mais surtout, des bénéfices.</h2>
    <table class="benefits-table">
      <thead>
        <tr>
          <th>Ce qu'il y a dans le guide</th>
          <th>Ce que ça vous apporte concrètement</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><span class="feat-pill">112 lieux</span></td>
          <td>Fini le tri infini. Une sélection éditoriale honnête à la place des listes exhaustives qui ne vous disent pas quoi choisir.</td>
        </tr>
        <tr>
          <td><span class="feat-pill">~3 photos / lieu</span></td>
          <td>Vous visualisez l'ambiance avant d'y aller. La photo n'illustre pas — elle aide à décider.</td>
        </tr>
        <tr>
          <td><span class="feat-pill">Cartes par zone</span></td>
          <td>Vous comprenez les distances réelles et construisez des journées logistiquement cohérentes.</td>
        </tr>
        <tr>
          <td><span class="feat-pill">6 pages inspiration</span></td>
          <td>Vous explorez selon vos envies du moment : volcans aujourd'hui, plages demain.</td>
        </tr>
        <tr>
          <td><span class="feat-pill">1 lieu = 1 page</span></td>
          <td>Comparer deux endroits prend 30 secondes. La décision devient simple, pas stressante.</td>
        </tr>
        <tr>
          <td><span class="feat-pill">Liens vers le site</span></td>
          <td>Les infos pratiques sont toujours à jour, sans que le guide ne vieillisse.</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- INSPIRATION -->
<section class="inspiration">
  <div class="inspiration-inner">
    <div class="section-tag tag-navy-outline">Explorer par envies</div>
    <h2 class="section-title section-title-lg" style="margin-bottom:12px;">6 lectures thématiques<br>de l'île.</h2>
    <p style="font-size:15px;color:var(--grey-text);max-width:500px;font-weight:300;line-height:1.7;">En plus des 112 fiches lieux, le guide propose des entrées par ambiances — pour explorer Tenerife selon ce qui vous attire vraiment.</p>
    <div class="inspi-grid">
      <div class="inspi-card">
        <div class="inspi-emoji">🌋</div>
        <div class="inspi-text">
          <strong>Découvertes volcaniques</strong>
          <span>Caldeira, coulées de lave, paysages lunaires</span>
        </div>
      </div>
      <div class="inspi-card">
        <div class="inspi-emoji">🏖️</div>
        <div class="inspi-text">
          <strong>Plages et baignade</strong>
          <span>Pour tous les goûts et profils</span>
        </div>
      </div>
      <div class="inspi-card">
        <div class="inspi-emoji">🥾</div>
        <div class="inspi-text">
          <strong>Marches & randonnées</strong>
          <span>Repères niveaux, paysages, durées</span>
        </div>
      </div>
      <div class="inspi-card">
        <div class="inspi-emoji">🌿</div>
        <div class="inspi-text">
          <strong>Jardins & oasis urbaines</strong>
          <span>Flore endémique et haltes vertes</span>
        </div>
      </div>
      <div class="inspi-card">
        <div class="inspi-emoji">👨‍👩‍👧</div>
        <div class="inspi-text">
          <strong>Ambiances familiales</strong>
          <span>Parcs, accès, durées adaptées</span>
        </div>
      </div>
      <div class="inspi-card">
        <div class="inspi-emoji">🏛️</div>
        <div class="inspi-text">
          <strong>Architecture canarienne</strong>
          <span>Patrimoine, balcons, villages historiques</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOCIAL PROOF -->
<section class="proof">
  <div class="proof-inner">
    <div class="section-tag tag-white-outline" style="margin-bottom:14px;">Ils nous font confiance</div>
    <h2 class="section-title section-title-lg" style="color:var(--white);">15 000 voyageurs ont déjà<br>choisi nos guides.</h2>
    <div class="proof-stats">
      <div class="proof-stat">
        <div class="proof-stat-num">+15 000</div>
        <div class="proof-stat-label">Guides Region Lovers<br>vendus</div>
      </div>
      <div class="proof-stat">
        <div class="proof-stat-num">+30 000</div>
        <div class="proof-stat-label">km parcourus<br>par notre équipe</div>
      </div>
      <div class="proof-stat">
        <div class="proof-stat-num">100%</div>
        <div class="proof-stat-label">indépendant<br>aucun sponsor</div>
      </div>
    </div>
    <div class="reviews-grid">
      <div class="review-card">
        <div class="review-stars">★★★★★</div>
        <p class="review-text">« C'est le guide le plus complet que j'ai trouvé et il rend l'organisation d'un voyage photographique beaucoup moins cauchemardesque. »</p>
        <div class="review-author">Noaemi</div>
      </div>
      <div class="review-card">
        <div class="review-stars">★★★★★</div>
        <p class="review-text">« Excellent ! Super excitée d'avoir trouvé quelque chose d'aussi utile comparé aux autres livres que j'ai achetés ! »</p>
        <div class="review-author">Sarra</div>
      </div>
      <div class="review-card">
        <div class="review-stars">★★★★★</div>
        <p class="review-text">« C'est génial ! Je trouve le guide très bien écrit, avec beaucoup d'informations pertinentes et utiles. Les photos sont incroyables — elles vous donnent vraiment envie d'y aller. »</p>
        <div class="review-author">Cristiana</div>
      </div>
    </div>
  </div>
</section>

<!-- PHILOSOPHY -->
<section class="philosophy">
  <div class="phil-inner">
    <div>
      <div class="section-tag tag-navy-outline">Region Lovers</div>
      <h2 class="section-title section-title-md phil-title">Un guide qui<br>vous respecte.</h2>
      <p class="phil-body">
        Chez Region Lovers, nous pensons qu'un bon guide ne doit pas seulement informer. Il doit aider à comprendre, comparer, choisir — et construire un voyage plus personnel.
        <br><br>
        Dans un monde saturé d'informations, notre ambition est simple : aider les voyageurs à y voir plus clair.
      </p>
      <div class="phil-creds">
        <div class="cred-row">+30 000 km parcourus par notre équipe de terrain</div>
        <div class="cred-row">100% indépendant — aucun partenariat commercial</div>
        <div class="cred-row">+15 000 guides vendus sur l'ensemble de la collection</div>
        <div class="cred-row">Connecté au site pour des infos toujours actualisées</div>
      </div>
    </div>
    <div class="phil-visual">
      <p class="phil-quote-text">
        « Nous ne cherchons pas à <span>accumuler les informations</span>. Nous aidons à <span>faire des choix</span>. »
      </p>
      <div class="phil-signature">Canarias Lovers</div>
    </div>
  </div>
</section>

<!-- TERRAIN & ENGAGEMENTS -->
<section style="background: var(--white); padding: 100px 40px;">
  <div style="max-width: 900px; margin: 0 auto;">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: start;">

      <!-- Gauche : le problème IA -->
      <div>
        <div class="section-tag tag-navy-outline">Nos engagements</div>
        <h2 class="section-title section-title-md" style="margin-bottom: 18px; color: var(--navy);">
          Un guide écrit<br>par des humains<br>qui y sont allés.
        </h2>
        <p style="font-size: 15px; color: var(--grey-text); line-height: 1.85; font-weight: 300; margin-bottom: 24px;">
          À l'heure où les guides de voyage se multiplient sans que personne ne soit jamais sur place, nous faisons le choix inverse : chaque lieu dont nous parlons, nous l'avons visité. Chaque photo, nous l'avons prise.
        </p>
        <p style="font-size: 15px; color: var(--grey-text); line-height: 1.85; font-weight: 300;">
          Pas de contenu généré, pas d'informations recyclées. Un regard humain, de terrain, 100% indépendant.
        </p>

        <!-- Signature -->
        <div style="margin-top: 32px; padding-top: 28px; border-top: 1px solid var(--grey); display: flex; align-items: center; gap: 16px;">
          <div>
            <div style="font-family: 'Meow Script', cursive; font-size: 26px; color: var(--yellow); line-height: 1.2;">Claire &amp; Manu</div>
            <div style="font-family: 'Raleway', sans-serif; font-size: 11px; font-weight: 700; color: var(--grey-text); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px;">Co-fondateurs · Region Lovers</div>
          </div>
        </div>
      </div>

      <!-- Droite : les engagements clés -->
      <div>
        <div style="background: var(--off-white); border-radius: 16px; padding: 32px; border: 1px solid rgba(25,30,85,0.07);">
          <div style="font-family: 'Raleway', sans-serif; font-size: 12px; font-weight: 800; color: var(--yellow); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 22px;">Nos 10 engagements</div>
          <div style="display: flex; flex-direction: column; gap: 14px;">

            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">01</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Visiter tous les lieux dont nous vous parlons.</span>
            </div>
            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">04</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Payer toutes nos factures. Refuser tout partenariat ou sponsoring.</span>
            </div>
            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">06</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Enrichir nos contenus de nos expériences de terrain, en première personne.</span>
            </div>
            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">07</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Utiliser 99% de nos propres photos.</span>
            </div>
            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">08</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Utiliser les outils numériques de façon raisonnée, en les alimentant d'informations vérifiées sur place.</span>
            </div>
            <div style="display: flex; gap: 14px; align-items: flex-start;">
              <span style="font-family: 'Raleway', sans-serif; font-weight: 900; font-size: 13px; color: var(--yellow); flex-shrink: 0; margin-top: 1px;">10</span>
              <span style="font-size: 13.5px; color: var(--navy); font-weight: 400; line-height: 1.5;">Dire ce que nous faisons, et faire ce que nous disons.</span>
            </div>
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
    <div class="section-tag tag-white-outline" style="margin-bottom:20px;">Prêt à partir ?</div>
    <h2 class="cta-title">
      Commencez à comprendre<br>
      <em>Tenerife dès aujourd'hui.</em>
    </h2>
    <p class="cta-body">
      Accès immédiat au guide numérique complet. Lisible sur smartphone, tablette et ordinateur. Connecté au site Canarias Lovers pour les informations pratiques à jour.
    </p>
    <div class="price-box">
      <div class="price-label">Guide numérique — Accès immédiat</div>
      <div class="price-amount"><sup>€</sup>XX</div>
      <div class="price-note">Paiement unique · Téléchargement immédiat</div>
      <a href="#" class="btn-primary" style="width:100%;justify-content:center;font-size:15px;padding:17px;">
        Obtenir le guide →
      </a>
    </div>
    <div class="cta-reassurances">
      <div class="reassure-item"><span class="check">✓</span> Accès immédiat après achat</div>
      <div class="reassure-item"><span class="check">✓</span> Optimisé smartphone & tablette</div>
      <div class="reassure-item"><span class="check">✓</span> 100% indépendant</div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-brand">Éditions Region Lovers · Canarias Lovers</div>
  <div class="footer-copy">© 2025 Region Lovers · Guide Tenerife</div>
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
    '.feature-card, .inspi-card, .review-card, .proof-stat'
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
