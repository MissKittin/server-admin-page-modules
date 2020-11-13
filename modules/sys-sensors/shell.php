<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/sys-sensors/shell.sh';

	if(isset($_GET['sensors']))
		echo '<pre>' . shell_exec($shell_sh_location . ' sensors') . '</pre>';
	else
	{ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }
?>