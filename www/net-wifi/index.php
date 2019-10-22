<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php chdir($system_location_php); ?>
<?php
	if(isset($_POST['add']))
	{
		shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi add ' . $_POST['add'] . ' ' . $_POST['password']);
	}
	if(isset($_POST['connect']))
	{
		shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi connect ' . $_POST['connect']);
	}
	if(isset($_POST['disconnect']))
	{
		shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi disconnect');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>WiFi</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
		<?php include($system_location_php . '/lib/opt_htmlheaders/jquery.php'); ?>
		<style type="text/css">
			tr {
				text-align: center;
			}
		</style>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#networks-list').load('<?php echo $system_location_html; ?>/net-wifi/shell.php?wifi');
				console.log('network list preloaded');
				list_refresh();
				console.log('list updating loop started');
			});
			function list_refresh()
			{
				setTimeout(function(){
					$('#networks-list').html('<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr><tr><td colspan="4">Scanning...</td></tr></table>');
					$('#networks-list').load('<?php echo $system_location_html; ?>/net-wifi/shell.php?wifi');
					list_refresh();
				}, 14400)
			}
			function manual_refresh()
			{
				console.log('updating list manually...');
				$('#networks-list').html('<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr><tr><td colspan="4">Scanning...</td></tr></table>');
				$('#networks-list').load('<?php echo $system_location_html; ?>/net-wifi/shell.php?wifi');
			}
		</script>
	</head>
	<body>
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
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
					<button name="disconnect" type="submit" value="disconnect">Disconnect</button>
					<input type="button" value="Refresh" onclick="javascript:manual_refresh();">
				</form>
				<?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh wifi print-connected'); ?>
			</div>
		</div>
	</body>
</html>