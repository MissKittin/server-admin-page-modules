<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	if(isset($_GET['hwclock']))
		echo shell_exec('date "+%d.%m.%Y %H:%M:%S"');
	else
	{ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }
?>