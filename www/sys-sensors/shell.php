<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	if(isset($_GET['sensors']))
		echo '<pre>' . shell_exec($system['location_php'] . strtok(str_replace('shell.php', '', $_SERVER['REQUEST_URI']), '?') . '/shell.sh sensors') . '</pre>';
	else
	{
		include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('shell.php');
	}
?>