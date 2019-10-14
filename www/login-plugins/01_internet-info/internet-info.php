<?php include($system_location_php . '/lib/prevent-direct.php'); prevent_direct('internet-info.php'); ?>
<div>
	<?php echo shell_exec($system_location_php . '/login-plugins/' . $plugin . '/shell.sh check-internet'); // ipv4 ?>
	<br>
	<?php echo shell_exec($system_location_php . '/login-plugins/' . $plugin . '/shell.sh check-ipv6'); // ipv6 ?>
</div>
