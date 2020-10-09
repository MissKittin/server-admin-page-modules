<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php $shell_sh_location=$system['location_php'] . '/sys-sensors/shell.sh'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sensors</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<?php include($system['location_php'] . '/lib/opt_htmlheaders/jquery.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(){
				statsRefresh();
				console.log('stats updating loop started');
			});

			function statsRefresh()
			{
				setTimeout(function(){
					$('#sensors').load('<?php echo $system['location_html']; ?>/sys-sensors/shell.php?sensors');
					statsRefresh();
				}, 400)
			}
		</script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Hardware sensors</h1>
				<div id="sensors">
					<pre><?php echo shell_exec($shell_sh_location . ' sensors'); ?></pre>
				</div>
			</div>
		</div>
	</body>
</html>