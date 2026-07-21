<?php
/**
 * Script de pré-remplissage ACF — Guide Tenerife
 * Textes + import automatique des images depuis assets/ du thème
 *
 * Usage WP-CLI (depuis la racine WordPress) :
 *   wp eval-file populate-tenerife.php
 *
 * Le script cherche une page dont le slug contient "tenerife" et le template
 * "page-landing-guide.php". Si plusieurs pages correspondent, il prend la première.
 */

/**
 * Importe un fichier depuis assets/ du thème dans la médiathèque WP.
 * Retourne l'ID de l'attachement (ou celui existant si déjà importé).
 */
function import_asset( string $filename, string $title = '' ): int|false {
	$theme_dir = get_stylesheet_directory();
	$file_path = $theme_dir . '/assets/' . $filename;

	if ( ! file_exists( $file_path ) ) {
		WP_CLI::warning( "Fichier introuvable : assets/{$filename} — champ image ignoré." );
		return false;
	}

	// Vérifier si déjà dans la médiathèque (évite les doublons)
	$slug     = sanitize_title( $title ?: pathinfo( $filename, PATHINFO_FILENAME ) );
	$existing = get_posts( [
		'post_type'      => 'attachment',
		'name'           => $slug,
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
	] );
	if ( $existing ) {
		WP_CLI::log( "  · {$filename} — déjà dans la médiathèque (ID {$existing[0]->ID})" );
		return $existing[0]->ID;
	}

	// Copier vers un fichier temporaire (requis par media_handle_sideload)
	$tmp = wp_tempnam( $filename );
	copy( $file_path, $tmp );

	$file_array = [
		'name'     => $filename,
		'tmp_name' => $tmp,
	];

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$attachment_id = media_handle_sideload( $file_array, 0, $title ?: $filename );

	if ( is_wp_error( $attachment_id ) ) {
		WP_CLI::warning( "Erreur import {$filename} : " . $attachment_id->get_error_message() );
		return false;
	}

	WP_CLI::log( "  · {$filename} → médiathèque ID {$attachment_id}" );
	return $attachment_id;
}

// Trouver la page Tenerife
$pages = get_posts( [
	'post_type'      => 'page',
	'posts_per_page' => 10,
	'meta_key'       => '_wp_page_template',
	'meta_value'     => 'page-landing-guide.php',
	'post_status'    => 'any',
] );

if ( empty( $pages ) ) {
	WP_CLI::error( 'Aucune page avec le template "Landing Guide" trouvée. Créez la page d\'abord dans WP Admin.' );
	return;
}

// Chercher la page Tenerife parmi les résultats
$page = null;
foreach ( $pages as $p ) {
	if ( stripos( $p->post_name, 'tenerife' ) !== false || stripos( $p->post_title, 'tenerife' ) !== false ) {
		$page = $p;
		break;
	}
}

// Fallback : prendre la première page avec ce template
if ( ! $page ) {
	$page = $pages[0];
}

$page_id = $page->ID;
WP_CLI::log( "Page trouvée : \"{$page->post_title}\" (ID {$page_id})" );

// ============================================================
// IMPORT DES IMAGES DEPUIS assets/ DU THÈME
// ============================================================

WP_CLI::log( 'Import des images...' );

$images = [
	'hero_cover_image'     => [ 'cover-tenerife.png',               'Couverture guide Tenerife' ],
	'pivot_image_1'        => [ 'guide-preview-eglise.png',         'Aperçu guide — Église Notre-Dame de la Conception' ],
	'pivot_image_2'        => [ 'guide-preview-teide.png',          'Aperçu guide — Parc national du Teide' ],
	'pivot_image_3'        => [ 'guide-preview-volcaniques.png',     'Aperçu guide — Découvertes volcaniques' ],
	'feuilletage_image_1'  => [ 'feuillet-preview-03.png',          'Feuillet — À propos de la destination, page 3' ],
	'feuilletage_image_2'  => [ 'feuillet-preview-13.png',          'Feuillet — Teleférico del Teide, page 13' ],
	'feuilletage_image_3'  => [ 'feuillet-preview-29.png',          'Feuillet — La Orotava, page 29' ],
	'feuilletage_image_4'  => [ 'feuillet-preview-120.png',         'Feuillet — Carte Anaga, page 120' ],
	'feuilletage_image_5'  => [ 'feuillet-preview-149.png',         'Feuillet — Plages et piscines naturelles, page 149' ],
	'feuilletage_image_6'  => [ 'feuillet-preview-156.png',         'Feuillet — Tenerife au printemps, page 156' ],
	'inspi_mockup_image'   => [ 'inspi-mockup-smartphone.png',      'Mockup smartphone — Découvertes volcaniques' ],
	'eng_portrait'         => [ 'claire-manu-region-lovers.png',    'Claire et Manu — co-fondateurs Region Lovers' ],
	'payment_logo_amex'        => [ 'logo-payment-amex.png',       'Logo paiement — American Express' ],
	'payment_logo_mastercard'  => [ 'logo-payment-mastercard.png', 'Logo paiement — Mastercard' ],
	'payment_logo_paypal'      => [ 'logo-payment-paypal.png',     'Logo paiement — PayPal' ],
	'payment_logo_visa'        => [ 'logo-payment-visa.png',       'Logo paiement — Visa' ],
];

$image_ids = [];
foreach ( $images as $field_name => [ $filename, $title ] ) {
	$id = import_asset( $filename, $title );
	if ( $id ) {
		$image_ids[ $field_name ] = $id;
		update_field( $field_name, $id, $page_id );
	}
}

WP_CLI::log( '' );

// ============================================================
// CONTENU TENERIFE
// ============================================================

$fields = [

	// --- HERO ---
	'hero_badge'        => '+15 000 vendus',
	'hero_kicker'       => 'guide numérique · 161 pages',
	'hero_title_dest'   => 'TENERIFE VOUS ATTEND,',
	'hero_title_em'     => 'construisez le voyage qui vous ressemble',
	'hero_subtitle'     => 'Choisir les bonnes zones, les bons lieux, les bonnes ambiances — et partir avec un voyage pensé pour vous, pas pour tout le monde.',
	'hero_stat_1_num'   => '112',
	'hero_stat_1_label' => 'lieux sélectionnés',
	'hero_stat_2_num'   => '161',
	'hero_stat_2_label' => 'pages',
	'hero_stat_3_num'   => '14',
	'hero_stat_3_label' => 'zones couvertes',
	'hero_stat_4_num'   => '6',
	'hero_stat_4_label' => 'pages inspiration',
	'hero_cta_primary'  => 'Obtenir le guide →',
	'hero_cta_secondary'=> 'Voir le contenu',

	// --- PIVOT ---
	'pivot_lede'        => 'Trop d\'infos, pas assez de clarté ?',
	'pivot_title'       => 'La plupart des guides accumulent, le nôtre aide à choisir',
	'pivot_body'        => 'Le guide Tenerife Canarias Lovers n\'est pas une base de données. C\'est un outil de décision — pensé pour smartphone et tablette — conçu pour vous permettre de comprendre la destination avant de réserver, et de construire un voyage personnel, pas générique.',
	'pivot_quote'       => '"Le guide vous aide à choisir. Notre site vous aide à organiser. Une philosophie simple, appliquée à chaque page."',
	'pivot_quote_cite'  => '— CANARIAS LOVERS',

	// --- FEUILLETAGE ---
	'feuilletage_tag'   => 'Un aperçu du guide',
	'feuilletage_title' => 'Feuilletez avant d\'acheter',
	'feuilletage_intro' => '112 lieux, 3 photos par lieu en moyenne, des cartes cliquables qui ouvrent la navigation GPS directement sur votre smartphone.',

	// --- TABLEAU CONTENU ---
	'benefits_tag'      => 'Le contenu',
	'benefits_title'    => 'Pour planifier avec plaisir, sans stress',
	'benefits_th_1'     => 'Ce qu\'il y a dans le guide',
	'benefits_th_2'     => 'Ce que vous en tirez concrètement',
	'benefit_1_feature' => '112 lieux',
	'benefit_1_value'   => 'Fini le tri infini. Une sélection éditoriale honnête à la place des listes exhaustives qui ne vous disent pas quoi choisir.',
	'benefit_2_feature' => '3 photos / lieu',
	'benefit_2_value'   => 'Vous visualisez l\'ambiance avant d\'y aller. La photo n\'illustre pas — elle aide à décider.',
	'benefit_3_feature' => '1 carte par zone',
	'benefit_3_value'   => 'Vous comprenez les distances réelles, construisez des journées cohérentes — et sur place, un tap ouvre la navigation GPS directement.',
	'benefit_4_feature' => '6 pages inspiration',
	'benefit_4_value'   => 'Vous explorez selon vos envies du moment : volcans aujourd\'hui, plages demain.',
	'benefit_5_feature' => '1 lieu = 1 page',
	'benefit_5_value'   => 'Comparer deux endroits prend 30 secondes. La décision devient simple, pas stressante.',
	'benefit_6_feature' => 'Liens vers le site',
	'benefit_6_value'   => 'Les infos pratiques de notre site sont toujours à jour — sans que le guide ne vieillisse.',

	// --- INSPIRATION ---
	'inspi_tag'         => 'Explorer par envies',
	'inspi_title'       => '6 lectures thématiques, de l\'île',
	'inspi_intro'       => 'En plus des 112 fiches lieux, le guide propose des entrées par ambiances — pour explorer Tenerife selon ce qui vous attire vraiment.',
	'inspi_1_emoji'     => '🌋',
	'inspi_1_title'     => 'Découvertes volcaniques',
	'inspi_1_desc'      => 'Caldeira, coulées de lave, paysages lunaires',
	'inspi_2_emoji'     => '🏖️',
	'inspi_2_title'     => 'Plages et baignade',
	'inspi_2_desc'      => 'Pour tous les goûts et profils',
	'inspi_3_emoji'     => '🥾',
	'inspi_3_title'     => 'Marches & randonnées',
	'inspi_3_desc'      => 'Repères niveaux, paysages, durées',
	'inspi_4_emoji'     => '🌿',
	'inspi_4_title'     => 'Jardins & oasis urbaines',
	'inspi_4_desc'      => 'Flore endémique et haltes vertes',
	'inspi_5_emoji'     => '👨‍👩‍👧',
	'inspi_5_title'     => 'Ambiances familiales',
	'inspi_5_desc'      => 'Parcs, accès, durées adaptées',
	'inspi_6_emoji'     => '🏛️',
	'inspi_6_title'     => 'Architecture canarienne',
	'inspi_6_desc'      => 'Patrimoine, balcons, villages historiques',

	// --- SOCIAL PROOF ---
	'proof_tag'          => 'Ils nous font confiance',
	'proof_title'        => '15 000 voyageurs ont déjà choisi nos guides',
	'proof_stat_1_num'   => '+15 000',
	'proof_stat_1_label' => "Guides Region Lovers\nvendus",
	'proof_stat_2_num'   => '+30 000',
	'proof_stat_2_label' => "km parcourus\npar notre équipe",
	'proof_stat_3_num'   => '100%',
	'proof_stat_3_label' => "indépendant\naucun sponsor",
	'review_1_text'      => '« C\'est le guide le plus complet que j\'ai trouvé et il rend l\'organisation d\'un voyage photographique beaucoup moins cauchemardesque. »',
	'review_1_author'    => 'Noaemi',
	'review_2_text'      => '« Excellent ! Super excitée d\'avoir trouvé quelque chose d\'aussi utile comparé aux autres livres que j\'ai achetés! »',
	'review_2_author'    => 'Sarra',
	'review_3_text'      => '« C\'est génial ! Je trouve le guide très bien écrit, avec beaucoup d\'informations pertinentes et utiles. Des informations telles que le temps nécessaire pour visiter un endroit sont très utiles pour planifier une visite. Et les photos sont incroyables – elles vous donnent vraiment envie d\'y aller »',
	'review_3_author'    => 'Cristiana',

	// --- ENGAGEMENTS ---
	'eng_tag'       => 'Nos engagements',
	'eng_title'     => "Un guide qui\nvous respecte",
	'eng_body_1'    => 'À l\'heure où les guides de voyage se multiplient sans que personne ne soit jamais sur place, nous faisons le choix inverse : chaque lieu dont nous parlons, nous l\'avons visité. Chaque photo, nous l\'avons prise.',
	'eng_body_2'    => 'Pas de contenu généré, pas d\'informations recyclées. Un regard humain, de terrain, 100% indépendant.',
	'eng_sig_name'  => 'Claire & Manu',
	'eng_sig_role'  => 'Co-fondateurs · Region Lovers',
	'eng_box_label' => 'Les 10 engagements de Region Lovers',
	'eng_item_1'    => 'Visiter tous les lieux dont nous vous parlons.',
	'eng_item_2'    => 'Pour chaque ville, dormir dans au moins un hôtel, visiter ceux que nous recommandons.',
	'eng_item_3'    => 'Pour chaque ville, manger dans au moins un restaurant, visiter ceux que nous sélectionnons.',
	'eng_item_4'    => 'Payer intégralement toutes nos factures, refuser tout partenariat ou sponsoring.',
	'eng_item_5'    => 'Mettre à jour périodiquement nos articles, avec l\'aide de nos lecteurs.',
	'eng_item_6'    => 'Enrichir nos articles par nos expériences sur place.',
	'eng_item_7'    => 'Utiliser à 99 % nos propres photos.',
	'eng_item_8'    => 'Avoir une utilisation raisonnée et transparente des outils numériques, que nous alimentons avec nos informations vérifiées sur place.',
	'eng_item_9'    => 'Informer sur le binôme voyageur/rédacteur qui a donné naissance à l\'article.',
	'eng_item_10'   => 'Vous dire ce que nous faisons, et faire ce que nous vous disons !',

	// --- CTA FINAL ---
	'cta_tag'         => 'Prêt à partir ?',
	'cta_title'       => 'Tenerife vous attend,',
	'cta_title_em'    => 'partez avec les bons choix',
	'cta_body'        => 'Accès immédiat au guide numérique complet. Lisible sur smartphone, tablette et ordinateur. Connecté à notre site Canarias Lovers pour les informations pratiques à jour.',
	'cta_price_label' => 'Guide numérique — Accès immédiat',
	'cta_price'       => '21',
	'cta_price_note'  => 'Paiement unique · Téléchargement immédiat',
	'cta_btn_label'   => 'Obtenir le guide →',
	'cta_url'         => '#',
	'cta_reassure_1'  => 'Plus de 15 000 guides vendus',
	'cta_reassure_2'  => 'Optimisé smartphone & tablette',
	'cta_reassure_3'  => 'Paiement sécurisé',
	'cta_reassure_4'  => 'Téléchargement immédiat',

	// --- FOOTER ---
	'footer_brand' => 'Éditions Region Lovers · Canarias Lovers',
	'footer_copy'  => '© 2025 Region Lovers · Guide Tenerife',
];

// ============================================================
// INJECTION
// ============================================================

$count   = 0;
$skipped = 0;

foreach ( $fields as $field_name => $value ) {
	$result = update_field( $field_name, $value, $page_id );
	if ( $result !== false ) {
		$count++;
	} else {
		// update_field renvoie false si la valeur est identique — pas une erreur
		$skipped++;
	}
}

$img_count = count( $image_ids );
WP_CLI::success( "{$count} champ(s) texte mis à jour + {$img_count} image(s) importée(s) sur la page ID {$page_id}." );
WP_CLI::log( '' );
WP_CLI::log( 'Pour vérifier :' );
WP_CLI::log( "  wp post meta list {$page_id} --keys" );
