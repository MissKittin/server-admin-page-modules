<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	// real-time shellscript output provider (for apt)
	if(isset($_GET['shell-command']))
	{
		echo '<body style="background-color: #ffffff;">';
		$a=popen($system['location_php'] . str_replace('shell.php', '', strtok($_SERVER['REQUEST_URI'], '?') . 'shell.sh ' . $_GET['shell-command']), 'r');

		while($b=fgets($a, 2048))
		{
			echo $b . "<br>\n";
			ob_flush();
			flush();
		}

		pclose($a);
	}
	else
	{
		include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('shell.php');
	}
?>