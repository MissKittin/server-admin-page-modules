<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	if((isset($_POST['apply'])) && (csrf_checkToken('post')))
		if($_POST['autoup'] === 'yes')
			shell_exec($system['location_php'] . '/net-wired/shell.sh set_onBoot yes');
		else
			shell_exec($system['location_php'] . '/net-wired/shell.sh set_onBoot no');

	if((isset($_POST['setstatic'])) && (csrf_checkToken('post')))
	{
		if($_POST['static'] === 'yes')
		{
			shell_exec($system['location_php'] . '/net-wired/shell.sh set_static enable');
			if(strpos($_POST['ip'], '\'') === false) shell_exec($system['location_php'] . '/net-wired/shell.sh set_static address ip ' . '\''.$_POST['ip'].'\'');
			if(strpos($_POST['mask'], '\'') === false) shell_exec($system['location_php'] . '/net-wired/shell.sh set_static address mask ' . '\''.$_POST['mask'].'\'');
			if(strpos($_POST['gateway'], '\'') === false) shell_exec($system['location_php'] . '/net-wired/shell.sh set_static address gateway ' . '\''.$_POST['gateway'].'\'');
			shell_exec($system['location_php'] . '/net-wired/shell.sh disconnect');
			shell_exec($system['location_php'] . '/net-wired/shell.sh connect');
		}
		else
		{
			shell_exec($system['location_php'] . '/net-wired/shell.sh set_static disable');
			shell_exec($system['location_php'] . '/net-wired/shell.sh disconnect');
			shell_exec($system['location_php'] . '/net-wired/shell.sh connect');
		}
	}

	if((isset($_POST['connect'])) && (csrf_checkToken('post')))
		shell_exec($system['location_php'] . '/net-wired/shell.sh connect');

	if((isset($_POST['disconnect'])) && (csrf_checkToken('post')))
		shell_exec($system['location_php'] . '/net-wired/shell.sh disconnect');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Wired</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Wired connection</h1>
				<?php
					echo shell_exec($system['location_php'] . '/net-wired/shell.sh info');
				?>
				<br>
				<form action="net-wired" method="post">
					Up interface on boot: <input type="checkbox" name="autoup" value="yes" <?php echo shell_exec($system['location_php'] . '/net-wired/shell.sh get_onBoot'); ?>> <input type="submit" class="system_button" name="apply" value="Apply"><br><br>
					Static IP: <input type="checkbox" name="static" value="yes" <?php echo shell_exec($system['location_php'] . '/net-wired/shell.sh get_static enabled'); ?>><br>
					IP: <input type="text" name="ip" value="<?php echo shell_exec($system['location_php'] . '/net-wired/shell.sh get_static address ip'); ?>"><br>
					Mask: <input type="text" name="mask" value="<?php echo shell_exec($system['location_php'] . '/net-wired/shell.sh get_static address mask'); ?>"><br>
					Gateway: <input type="text" name="gateway" value="<?php echo shell_exec($system['location_php'] . '/net-wired/shell.sh get_static address gateway'); ?>"><br>
					<input type="submit" class="system_button" name="setstatic" value="Apply"><br><br>
					<input type="submit" class="system_button" name="connect" value="Connect"> <input type="submit" class="system_button" name="disconnect" value="Disconnect">
					<?php echo csrf_injectToken(); ?>
				</form>
			</div>
		</div>
	</body>
</html>