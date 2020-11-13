<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/net-devices/shell.sh';
	$ALERT='';

	if(csrf_checkToken('post'))
	{
		if(isset($_POST['reserve-name']))
		{
			if(strpos($_POST['reserve-name'].$_POST['reserve-ip'].$_POST['reserve-mac'], '\'') === false) shell_exec($shell_sh_location . ' net-reserve add ' . '\''.$_POST['reserve-name'].'\'' . ' ' . '\''.$_POST['reserve-ip'].'\'' . ' ' . '\''.$_POST['reserve-mac'].'\'');
			$ALERT='onload="javacript:reserve(\'' . $_POST['reserve-name'] . '\', \'' . $_POST['reserve-ip'] . '\');"';
		}
		if(isset($_POST['release']))
		{
			$params = explode(' ', $_POST['release']);
			if($params[1] == '')
				$ALERT='onload="javacript:lerror(\'MAC address empty, interrupted\');"';
			else
				if(strpos($params[2].$params[0].$params[1], '\'') === false) shell_exec($shell_sh_location . ' net-reserve del ' . '\''.$params[2].'\'' . ' ' . '\''.str_replace('_', '.', $params[0]).'\'' . ' ' . '\''.$params[1].'\'');
		}

		if(isset($_POST['ban']))
		{
			if(strpos($_POST['ban'], '\'') === false) shell_exec($shell_sh_location . ' net-block ban ' . '\''.str_replace('_', '.', $_POST['ban']).'\'');
			$ALERT='onload="javacript:ban(\'' . str_replace('_', '.', $_POST['ban']) . '\');"';
		}
		if(isset($_POST['unban']))
		{
			if(strpos($_POST['unban'], '\'') === false) shell_exec($shell_sh_location . ' net-block unban ' . '\''.str_replace('_', '.', $_POST['unban']).'\'');
			$ALERT='onload="javacript:unban(\'' . str_replace('_', '.', $_POST['unban']) . '\');"';
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Devices</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			tr, td, th { border: 1px solid var(--content_border-color); }
			table { border-collapse: collapse; }
			#details tr, #details td, #details th { border: none; text-align: center; }
		</style>
		<script type="text/javascript">
			function reserve(device, ip){ alert(device + " at " + ip + " reserved"); }
			function ban(device){ alert(device + " banned"); }
			function unban(device){ alert(device + " freed"); }
			function limit(device){ alert(device + " limited"); }
			function lerror(message){ alert(message); }
		</script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<?php if(isset($_POST['reserve'])) { ?>
					<h1>Reserve</h1>
					<form action="net-devices" method="post">
						<?php $params = explode(' ', $_POST['reserve']); ?>
						Device name: <input type="text" name="reserve-name" value="<?php echo $params[2]; ?>" required><br>
						Device IP: <input type="text" name="reserve-ip" value="<?php echo str_replace('_', '.', $params[0]); ?>" required><br>
						Device MAC: <input type="text" name="reserve-mac" value="<?php echo $params[1]; ?>" required><br>
						<input type="submit" class="system_button" value="Reserve">
						<?php echo csrf_injectToken(); ?>
					</form>
				<?php } else { ?>
					<h1>Devices</h1>
					<form action="net-devices" method="post">
						<table>
							<tr><th>Stat</th><th>Hostname</th><th>IP</th><th>MAC</th><th>Reserved</th></tr>
							<?php echo shell_exec($shell_sh_location . ' list-devices'); ?>
							<?php echo csrf_injectToken(); ?>
						</table>
					</form>
					<?php
						if(isset($_GET['details']))
						{
							echo '<br><table id="details">
								<tr><td><span style="font-weight: bold;">&#10004;</span></td><td>active</td></tr>
								<tr><td><span style="font-weight: bold;">&#10008;</span></td><td>free</td></tr>
								<tr><td><span>&#9760;</span></td><td>abandoned</td></tr>
								<tr><td><span style="font-weight: bold;">?</span></td><td>unknown</td></tr>
							</table><hr>';
							echo shell_exec($shell_sh_location . ' net-reserve details');
						}
						else
							echo '<a href="?details" class="content_noDecorations">More details</a>';
					?>
				<?php } ?>
			</div>
		</div>
	</body>
</html>