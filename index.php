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
</head>
<body>
	<?php
	include($SERVER_ROOT . '/includes/header.php');
	?>
	<div class="navpath"></div>
	<main id="innertext">
		<h1 class="page-heading">Welcome to the Minnesota Biodiversity Atlas!</h1>
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
	</main>
	<?php
	include($SERVER_ROOT . '/includes/footer.php');
	?>
</body>
</html>
