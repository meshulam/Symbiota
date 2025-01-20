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
		<h1 class="page-heading"><?php echo $DEFAULT_TITLE; ?> Home</h1>
		<div>
			<p>
				Minnesota is home to the convergence of three of the largest terrestrial
				ecosystems in the world. Broadleaf forest, prairie, and boreal forest meet
				near the headwaters of the Mississippi River. Our climate is extremely
				seasonal and changing faster than ever before in human history.
				Here in Minnesota many species are at the edge of their geographic range,
				and change is predicted to occur faster where biomes meet. The Minnesota
				Biodiversity Atlas, a searchable database of birds, mammals, fishes,
				insects, plants, fungi and more, brings together accurate records of
				species distribution, and helps us track, understand, and map these changes
				as they happen.
			</p>
			<p>
				Our state is home to a rich record of biodiversity collections including
				natural history specimens and expert observations dating from the 19th
				century up to the present. The Minnesota Biodiversity Atlas provides access
				to more than 60 terabytes of records and digital images from academic institutions
				and  government agencies including the Bell Museum. As the most comprehensive
				source of biodiversity information in the state, the Atlas also includes records
				of life elsewhere collected by Minnesotans or residing in Minnesota museums.<br/>
			</p>
			<p>
				Hosted by the Bell Museum and the Minnesota Supercomputing Institute, the Atlas
				includes more than two million records of biodiversity from all seven continents.
				Contemporary observations and historic records predating the digital age are
				added to the Atlas as it continues to grow. So far more than 1.6 million records
				are mapped to a geographic location and over 500,000 digital images of specimens
				and field observations are searchable online.<br/>
			</p>
			<p>
				You can help us add more specimens to the Atlas with
				<a href="https://www.zooniverse.org/projects/zooniverse/mapping-change">Mapping Change</a>,
				a citizen science project supported by the Bell Museum and the Zooniverse. Your
				contributions will help us know where species have been and predict where they
				may end up in the future!
			</p>
			<p>
				Visit the <a href="http://bellmuseum.umn.edu">Bell Museum</a>
				for more about natural history collections.
			</p>
			<p>
				Funding for this project was provided by the
				<a href="https://www.legacy.mn.gov/environment-natural-resources-trust-fund">Minnesota Environment and Natural Resources Trust Fund</a>
				as recommended by the Legislative-Citizen Commission on	Minnesota Resources (LCCMR).
				The Trust Fund is a permanent fund constitutionally established by the citizens of
				Minnesota to assist in the protection, conservation, preservation, and enhancement
				of the state's air, water, land, fish, wildlife, and other natural resources.
			</p>
			<div style="width:100%;display:flex;flex-wrap:wrap">
				<img src="<?= $CLIENT_ROOT ?>/images/umn/Bell-logo.png" style="display:inline-block;width:300px;margin:auto;"/>
				<img src="<?= $CLIENT_ROOT ?>/images/umn/enrtf_logo.jpg" style="display:inline-block;width:200px;margin:auto;"/>
			</div>
			<div>
				<a href="<?= $CLIENT_ROOT ?>/collections/index.php" >
					<img src="<?= $CLIENT_ROOT ?>/images/umn/BiodiversityAtlas_search.jpg" style="margin-top:0px;border:black solid 1px;"/>
				</a>
				<a href="<?= $CLIENT_ROOT ?>/collections/map/mapinterface.php" target="_blank">
					<img src="<?= $CLIENT_ROOT ?>/images/umn/BiodiversityAtlas_Maps.jpg" style="margin-top:5px;border:black solid 1px;"/>
				</a>
				<a href="<?= $CLIENT_ROOT ?>/imagelib/search.php" >
					<img src="<?= $CLIENT_ROOT ?>/images/umn/BiodiversityAtlas_Image.jpg" style="margin-top: 5px;border:black solid 1px;"/>
				</a>
			</div>
		</div>
	</main>
	<?php
	include($SERVER_ROOT . '/includes/footer.php');
	?>
</body>
</html>
