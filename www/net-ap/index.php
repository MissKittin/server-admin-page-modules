<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/net-ap/shell.sh';

	if((isset($_POST['ssid'])) && (csrf_checkToken('post')))
	{
		//ssid
		if(strpos($_POST['ssid'], '\'') === false) shell_exec($shell_sh_location . ' ap set ssid ' . '\''.$_POST['ssid'].'\'');

		//password
		if($_POST['password'] != '')
			if(strpos($_POST['password'], '\'') === false) shell_exec($shell_sh_location . ' ap set password ' . '\''.$_POST['password'].'\'');

		//hide ssid
		if(isset($_POST['hide-ssid']))
		{
			if($_POST['hide-ssid'] === 'yes')
				shell_exec($shell_sh_location . ' ap set hide-ssid yes');
		}
		else
			shell_exec($shell_sh_location . ' ap set hide-ssid no');

		//mode
		if(strpos($_POST['mode'], '\'') === false) shell_exec($shell_sh_location . ' ap set mode ' . '\''.$_POST['mode'].'\'');
		//channel
		if(strpos($_POST['channel'], '\'') === false) shell_exec($shell_sh_location . ' ap set channel ' . '\''.$_POST['channel'].'\'');
		//restart daemon
		shell_exec($shell_sh_location . ' ap restart');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Access Point</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Access Point</h1>
				<form action="net-ap" method="post">
					SSID: <input type="text" name="ssid" value="<?php echo shell_exec($shell_sh_location . ' ap get ssid'); ?>" required="required"><br>
					Change password: <input type="password" name="password"><br>
					Hide SSID: <input type="checkbox" name="hide-ssid" value="yes" <?php echo shell_exec($shell_sh_location . ' ap get hide-ssid'); ?>><br>
					Mode:
					<select name="mode">
						<?php echo shell_exec($shell_sh_location . ' ap get mode'); ?>
					</select><br>
					Channel:
					<select name="channel">
						<?php echo shell_exec($shell_sh_location . ' ap get channel'); ?>
					</select><br>
					<input type="submit" class="system_button" value="Set">
					<?php echo csrf_injectToken(); ?>
				</form>
			</div>
		</div>
	</body>
</html>