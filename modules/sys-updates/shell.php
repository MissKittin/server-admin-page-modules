<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/sys-updates/shell.sh';

	// real-time shellscript output provider (for apt)
	if((isset($_GET['shell-command'])) && (csrf_checkToken('get')))
	{
		if(strpos($_GET['shell-command'], '\''))
		{
			header('X-Frame-Options: SAMEORIGIN'); // allow iframe
			echo '<body style="background-color: #ffffff;">'; // force background color
			$a=popen($shell_sh_location . ' \''.$_GET['shell-command'].'\'', 'r');
			while($b=fgets($a, 2048))
			{
				echo $b . "<br>\n";
				ob_flush();
				flush();
			}
			pclose($a);
		}
		else
		{ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }
	}
	else
	{ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }
?>