<?php
/**
 * kiosk.php is set as the homepage on the Atlas kiosk in the Bell Museum.
 * When the 'kiosk' cookie is set, links always open in the same window.
 */
setcookie('kiosk','1');
header("Location: index.php");
?>
