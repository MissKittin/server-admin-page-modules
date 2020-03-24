<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('config.php'); ?>
<?php
	// storage configuration - ram disks

	$ram_disks=['tmp', 'udev', 'log', 'spool', 'homes']; // main
	array_push($ram_disks, 'php', 'dhcp', 'nfs', 'sudo', 'samba'); // additional
?>