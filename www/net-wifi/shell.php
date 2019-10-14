<?php $session_regenerate=false; include($system_location_php . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	if(isset($_GET['wifi']))
	{
		echo '<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr>';
		echo shell_exec($system_location_php . str_replace('shell.php', '', strtok($_SERVER['REQUEST_URI'], '?')) . 'shell.sh wifi list-aps ' . $system_location_php);
		echo '</table>';
	}
	else
	{
		include($system_location_php . '/lib/prevent-direct.php'); prevent_direct('shell.php');
	}
?>