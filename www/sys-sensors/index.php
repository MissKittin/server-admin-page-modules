<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php chdir($system_location_php); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sensors</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
		<?php include($system_location_php . '/lib/opt_htmlheaders/jquery.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(){
				statsRefresh();
				console.log('stats updating loop started');
			});

			function statsRefresh()
			{
				setTimeout(function(){
					$('#sensors').load('<?php echo $system_location_html; ?>/sys-sensors/shell.php?sensors');
					statsRefresh();
				}, 400)
			}
		</script>
	</head>
	<body>
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
				<h1>Hardware sensors</h1>
				<div id="sensors">
					<pre><?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh sensors'); ?></pre>
				</div>
			</div>
		</div>
	</body>
</html>