<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php chdir($system_location_php); ?>
<?php
	if(isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case 'enable':
				echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh notify-daemon-settings set enable ' . $_GET['type'] . ' ' . $_GET['name']);
			break;
			case 'disable':
				echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh notify-daemon-settings set disable ' . $_GET['type'] . ' ' . $_GET['name']);
			break;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Notifications</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
				<h1>Notifications</h1>
				Daemon: <?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh notify-daemon-settings status');?>
				<?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh notify-daemon-settings print'); // notify-daemon-settings print $3 is not needed anymore ?>
			</div>
		</div>
	</body>
</html>