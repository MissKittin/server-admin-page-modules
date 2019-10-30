<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php
	switch($_GET['do'])
	{
		case 'halt':
			shell_exec('halt');
			break;
		case 'reboot':
			shell_exec('reboot');
			break;
		case 'suspend':
			shell_exec('nohup ' . $system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh suspend > /dev/null 2>&1 &');
			break;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shutdown</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<?php include 'favicon.php'; ?>
	</head>
	<body>
		<h1>Doing <?php echo $_GET['do']; ?>...</h1>
		You can close tab.
	</body>
</html>