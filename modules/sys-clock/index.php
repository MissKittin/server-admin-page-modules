<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	if((isset($_POST['sync-system-clock'])) && (csrf_checkToken('post')))
		$ntpdate_output=shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh sync-clock');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Clock</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<?php include($system['location_php'] . '/lib/opt_htmlheaders/jquery.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(){
				clock_refresh();
				//console.log('clock updating loop started');
			});
			function clock_refresh()
			{
				setTimeout(function(){
					$('#hwclock').load('<?php echo $system['location_html']; ?>/sys-clock/shell.php?hwclock');
					clock_refresh();
				}, 1000)
			}
		</script>
	</head>
	<bodyz>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Clock</h1>
				<form action="sys-clock" method="post">
					<span id="hwclock"><?php echo shell_exec('date "+%d.%m.%Y %H:%M:%S"'); ?></span>
					<input type="submit" class="system_button" name="sync-system-clock" value="Sync">
					<?php echo csrf_injectToken(); ?>
				</form>
				<?php if(isset($ntpdate_output)) echo '<h2>Sync result</h2>' . $ntpdate_output; ?>
			</div>
		</div>
	</body>
</html>