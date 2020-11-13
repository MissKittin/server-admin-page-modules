<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	if(isset($_GET['wifi']))
	{
		if(isset($_GET['disconnect']))
		{
			shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi disconnect');
			exit();
		}

		echo '<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr>';
		echo shell_exec($system['location_php'] . str_replace('shell.php', '', strtok($_SERVER['REQUEST_URI'], '?')) . 'shell.sh wifi list-aps ' . $system['location_html'] . '/lib/range_icons');
		echo '</table>';
	}
	else
	{
		include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('shell.php');
	}
?>