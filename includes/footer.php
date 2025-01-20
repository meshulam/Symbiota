<?php /* bellatlas: site-specific file, in upstream's .gitignore */ ?>
<footer>
	<div class="logo-gallery">
		<?php
		//include($SERVER_ROOT . '/accessibility/module.php');
		?>
		<a href="https://www.nsf.gov" target="_blank" aria-label="<?= $LANG['F_VISIT_NSF'] ?>">
			<img src="<?= $CLIENT_ROOT; ?>/images/layout/logo_nsf.gif" alt="<?= $LANG['F_NSF_LOGO'] ?>" />
		</a>
		<a href="http://idigbio.org" target="_blank" title="iDigBio" aria-label="<?= $LANG['F_VISIT_IDIGBIO'] ?>">
			<img src="<?= $CLIENT_ROOT; ?>/images/layout/logo_idig.png" alt="<?= $LANG['F_IDIGBIO_LOGO'] ?>" />
		</a>
		<a href="https://biokic.asu.edu" target="_blank" title="<?= $LANG['F_BIOKIC'] ?>" aria-label="Visit BioKIC website">
			<img src="<?= $CLIENT_ROOT; ?>/images/layout/logo-asu-biokic.png"  alt="<?= $LANG['F_BIOKIC_LOGO'] ?>" />
		</a>
	</div>
	<p>
		<?= $LANG['F_POWERED_BY'] ?> <a href="https://symbiota.org/" target="_blank">Symbiota</a>.
		<?= $LANG['F_MORE_INFO'] ?>, <a href="https://symbiota.org/docs" target="_blank" rel="noopener noreferrer"><?= $LANG['F_READ_DOCS'] ?></a> <?= $LANG['F_CONTACT'] ?>
		<a href="https://symbiota.org/contact-the-support-hub/" target="_blank" rel="noopener noreferrer"><?= $LANG['F_SSH'] ?></a>.
	</p>
	<p>
		&copy; <span id="cdate">2025</span> Regents of the University of Minnesota. All rights reserved.
		The University of Minnesota is an equal opportunity educator and employer. <a href="http://privacy.umn.edu">Privacy Statement</a>
	</p>
	<script>document.getElementById('cdate').innerHTML = new Date().getFullYear();</script>
</footer>
