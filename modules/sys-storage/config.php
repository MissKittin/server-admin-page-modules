<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('config.php'); ?>
<?php
	// storage configuration - ram disks
	$ram_disks=['tmp', 'home'];
?>