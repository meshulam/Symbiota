<?php
/* bellatlas: site-specific file, in upstream's .gitignore */
/*
** Style sheets are determined by $CSS_BASE_PATH set within config/symbini.php
** Customization can be made by modifying css files, $CSS_BASE_PATH, adding new css files below
*/
?>
<!-- Responsive viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

<!-- Symbiota styles -->
<link rel="shortcut icon" href="/images/umn/favicon.ico">
<link href="<?= $CSS_BASE_PATH ?>/symbiota/header.css?ver=<?= $CSS_VERSION ?>" type="text/css" rel="stylesheet">
<link href="<?= $CSS_BASE_PATH ?>/symbiota/footer.css?ver=<?= $CSS_VERSION ?>" type="text/css" rel="stylesheet">
<link href="<?= $CSS_BASE_PATH ?>/symbiota/main.css?ver=<?= $CSS_VERSION ?>" type="text/css" rel="stylesheet">
<link href="<?= $CSS_BASE_PATH ?>/umn.css?ver=<?= $CSS_VERSION ?>" type="text/css" rel="stylesheet">
<link href="<?= $CSS_BASE_PATH ?>/symbiota/customizations.css?ver=<?= $CSS_VERSION ?>" type="text/css" rel="stylesheet">

<script src="<?= $CLIENT_ROOT ?>/js/symb/lang.js" type="text/javascript"></script>
<?php include_once($SERVER_ROOT . '/includes/kioskmode.php'); ?>