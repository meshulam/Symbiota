<?php
/* bellatlas: site-specific file, in upstream's .gitignore */
if($LANG_TAG == 'en' || !file_exists($SERVER_ROOT.'/content/lang/templates/header.' . $LANG_TAG . '.php'))
	include_once($SERVER_ROOT . '/content/lang/templates/header.en.php');
else include_once($SERVER_ROOT . '/content/lang/templates/header.' . $LANG_TAG . '.php');
$SHOULD_USE_HARVESTPARAMS = $SHOULD_USE_HARVESTPARAMS ?? false;
$collectionSearchPage = $SHOULD_USE_HARVESTPARAMS ? '/collections/index.php' : '/collections/search/index.php';
?>
<div class="header-wrapper">
	<div class="umnhf" id="umnhf-h" role="banner">
		<a class="screen-reader-only" href="#end-nav"><?= $LANG['H_SKIP_NAV'] ?></a>
		<div class="printer"><div class="left"></div><div class="right"><strong>University of Minnesota</strong><br />https://www.umn.edu/<br />612-625-5000</div></div>
		<div class="umnhf" id="umnhf-h-mast">
			<a class="umnhf" id="umnhf-h-logo" href="https://twin-cities.umn.edu/"><span>Go to the U of M home page</span></a>
			<ul class="umnhf" id="umnhf-h-ql">
				<li><a href="http://onestop.umn.edu/">One Stop</a></li>
				<li class="umnhf"><a href="https://www.myu.umn.edu/">MyU <span></span>: For Students, Faculty, and Staff</a></li>
			</ul>
			<!-- Button below is for dropdown toggle, only visible on mobile screens. If using
			a non-dropdown version you can delete this tag -->
			<button class="umnhf" id="umnhf-m-search">Search</button>
		</div>
		<form class="umnhf" id="umnhf-h-search" action="https://www.bellmuseum.umn.edu/" method="get" title="Search the Bell Museum Website" role="search">
			<label class="umnhf" for="umnhf-h-st" for="s">Search the Bell Museum Website</label>
			<input class="umnhf" id="umnhf-h-st" type="text" name="s" id="s" value="" placeholder="search the bell">
			<input aria-hidden="true" type="hidden" name="search-type" value="normal">
			<input class="umnhf" id="umnhf-h-sb" type="submit" value="">
		</form>
	</div>
	<header>
		<div class="top-wrapper">
			<nav class="top-login" aria-label="horizontal-nav">
				<?php
				if ($USER_DISPLAY_NAME) {
					?>
					<div class="welcome-text">
						<?= $LANG['H_WELCOME'] . ' ' . $USER_DISPLAY_NAME ?>!
					</div>
					<span id="profile">
						<form name="profileForm" method="post" action="<?= $CLIENT_ROOT . '/profile/viewprofile.php' ?>">
							<button class="button button-tertiary left-breathing-room-rel" name="profileButton" type="submit"><?= $LANG['H_MY_PROFILE'] ?></button>
						</form>
					</span>
					<span id="logout">
						<form name="logoutForm" method="post" action="<?= $CLIENT_ROOT ?>/profile/index.php?submit=logout">
							<button class="button button-secondary left-breathing-room-rel" name="logoutButton" type="submit"><?= $LANG['H_LOGOUT'] ?></button>
						</form>
					</span>
					<?php
				} else {
					?>
					<span id="login">
						<form name="loginForm" method="post" action="<?= $CLIENT_ROOT . "/profile/index.php" ?>">
							<input name="refurl" type="hidden" value="<?= htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . "?" . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES) ?>">
							<button class="button button-secondary left-breathing-room-rel" name="loginButton" type="submit"><?= $LANG['H_LOGIN'] ?></button>
						</form>
					</span>
					<?php
				}
				?>
			</nav>
			<div class="top-brand">
				<div class="brand-name">
					<h1><a href="<?= $CLIENT_ROOT ?>">Minnesota Biodiversity Atlas</a></h1>
				</div>
			</div>
		</div>
		<div class="menu-wrapper">
			<!-- Hamburger icon -->
			<input class="side-menu" type="checkbox" id="side-menu" name="side-menu" />
			<label class="hamb hamb-line hamb-label" for="side-menu" tabindex="0">☰ Menu</label>
			<!-- Menu -->
			<nav class="top-menu" aria-label="hamburger-nav">
				<ul class="menu">
					<li>
						<a href="<?= $CLIENT_ROOT ?>/index.php">
							<?= $LANG['H_HOME'] ?>
						</a>
					</li>
					<li>
						<a href="<?= $CLIENT_ROOT . $collectionSearchPage ?>">
							<?= $LANG['H_SEARCH'] ?>
						</a>
					</li>
					<li>
						<a href="<?= $CLIENT_ROOT ?>/collections/map/index.php" rel="noopener noreferrer">
							<?= $LANG['H_MAP_SEARCH'] ?>
						</a>
					</li>
					<li>
						<a href="<?= $CLIENT_ROOT ?>/imagelib/search.php">
							<?= $LANG['H_IMAGES'] ?>
						</a>
					</li>
					<li>
						<a href="<?= $CLIENT_ROOT ?>/taxa/taxonomy/taxonomydisplay.php">
							Taxonomy
						</a>
					</li>
					<li>
						<a href="<?= $CLIENT_ROOT ?>/checklists/index.php">
							Checklists
						</a>
					</li>
					<li>
						<a href='<?= $CLIENT_ROOT ?>/sitemap.php'>
							<?= $LANG['H_SITEMAP'] ?>
						</a>
					</li>
					<li>
						<a href="#">Extras</a>
						<ul>
							<li>
								<a href="<?= $CLIENT_ROOT ?>/includes/usagepolicy.php">
									<?= $LANG['H_DATA_USAGE'] ?>
								</a>
							</li>
							<li>
								<a href="https://symbiota.org/docs" target="_blank" rel="noopener noreferrer">
									<?= $LANG['H_HELP'] ?>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<div id="end-nav"></div>
	</header>
</div>
