<?php
/* bellatlas: site-specific file, in upstream's .gitignore */
include_once('config/symbini.php');
if($LANG_TAG == 'en' || !file_exists($SERVER_ROOT.'/content/lang/templates/index.'.$LANG_TAG.'.php')) include_once($SERVER_ROOT.'/content/lang/templates/index.en.php');
else include_once($SERVER_ROOT.'/content/lang/templates/index.'.$LANG_TAG.'.php');
header('Content-Type: text/html; charset=' . $CHARSET);
?>
<!DOCTYPE html>
<html lang="<?php echo $LANG_TAG ?>">
<head>
	<title><?php echo $DEFAULT_TITLE; ?> Home</title>
	<?php
	include_once($SERVER_ROOT . '/includes/head.php');
	include_once($SERVER_ROOT . '/includes/googleanalytics.php');
	?>
	<link href="<?= $CSS_BASE_PATH ?>/jquery-ui.css" type="text/css" rel="stylesheet">
	<style>
		@media (min-width: 768px) {
			.body-cols {
				display: flex;
				gap: 2rem;
			}
		}
	</style>
</head>
<body>
	<?php
	include($SERVER_ROOT . '/includes/header.php');
	?>
	<div class="navpath"></div>
	<main id="innertext">
		<h1 class="page-heading">Welcome to the Minnesota Biodiversity Atlas!</h1>
		<div class="body-cols">
			<div>
				<p>
					Minnesota is home to the convergence of the three largest ecosystems in North America: broadleaf forest, prairie, and boreal forest. 
					More than 9,000 different species reside here and records dating from the 19th century up to the present are hosted in the Minnesota 
					Biodiversity Atlas.
				</p>
				<p>
					This searchable database provides access to biodiversity from all 87 Minnesota counties. Global biodiversity data housed in Minnesota 
					can also be found here. With more than two million records and 500,000 images this publicly available resource continues to grow.
				</p>
				<p>
					Funding for this <a href="https://www.bellmuseum.umn.edu/" target="_blank">Bell Museum</a> project was provided by the 
					<a href="https://www.legacy.mn.gov/environment-natural-resources-trust-fund" target="_blank">Minnesota Environment and Natural Resources Trust Fund</a>
					as recommended by the Legislative-Citizen Commission on Minnesota Resources (LCCMR). The Trust Fund is a permanent fund constitutionally 
					established by the citizens of Minnesota to assist in the protection, conservation, preservation, and enhancement of the state's 
					air, water, land, fish, wildlife, and other natural resources.
				</p>
			</div>
			<div class="slidshow-box bottom-breathing-room">
				<script src="<?php echo $CLIENT_ROOT; ?>/js/jquery-3.7.1.min.js" type="text/javascript"></script>
				<script src="<?php echo $CLIENT_ROOT; ?>/js/jquery-ui.min.js" type="text/javascript"></script>
				<script src="<?php echo $CLIENT_ROOT; ?>/js/jquery.slides.js"></script>
				<?php
					$imgIDs = [
						648344, // hummingbird
						368820, // Ipomopsis
						648345, // skull
						47520, // Prunus
						360790, // Liriodendron
						648346, // fish
						360788, // Pourouma
					];

					//Enter width of slideshow window (in pixels, minimum 275, maximum 800)
					$width = 375;

					//Enter amount of time (in milliseconds) between rotation of images
					$interval = 5000;
					include_once($SERVER_ROOT.'/classes/PluginsManager.php');
					$pluginManager = new PluginsManager();
					echo $pluginManager->createImageIDSlideShow($imgIDs,$width,$interval);
				?>
			</div>
		</div>
	</main>
	<?php
	include($SERVER_ROOT . '/includes/footer.php');
	?>
</body>
</html>
