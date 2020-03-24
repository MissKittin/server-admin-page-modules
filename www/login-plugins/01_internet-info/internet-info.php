<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('internet-info.php'); ?>
<div>
	<?php echo shell_exec($system['location_php'] . '/login-plugins/' . $plugin . '/shell.sh check-internet'); // ipv4 ?>
	<br>
	<?php echo shell_exec($system['location_php'] . '/login-plugins/' . $plugin . '/shell.sh check-ipv6'); // ipv6 ?>
</div>
