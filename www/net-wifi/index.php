<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	if(isset($_POST['add']))
		shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi add ' . $_POST['add'] . ' ' . $_POST['password']);

	if(isset($_POST['connect']))
		shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi connect ' . $_POST['connect']);

	if(isset($_POST['disconnect']))
		shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi disconnect');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>WiFi</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<?php include($system['location_php'] . '/lib/opt_htmlheaders/jquery.php'); ?>
		<script type="text/javascript" src="<?php echo $system['location_html'] . strtok($_SERVER['REQUEST_URI'], '?'); ?>/script.php?root=<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>"></script>
		<style type="text/css">
			tr {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>WiFi</h1>
				<form action="net-wifi" method="post" >
					<div id="networks-list"><?php /* content is only temporary for layout */ ?>
						<table>
							<tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr>
							<tr><td colspan="4">
								<span id="jawaskript" style="color: #ff0000;">Enable javascript</span>
								<script>
									document.getElementById('jawaskript').style.color='#000000';
									document.getElementById('jawaskript').innerHTML='Scanning...';
								</script>
							</td></tr>
						</table>
					</div>
					<br>
					<button class="system_button" name="disconnect" type="submit" value="disconnect">Disconnect</button>
					<input type="button" value="Refresh" id="manualRefresh">
				</form>
				<?php echo shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi print-connected'); ?>
			</div>
		</div>
	</body>
</html>