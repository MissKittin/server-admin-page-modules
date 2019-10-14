<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php chdir($system_location_php); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sensors</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
				<h1>Hardware sensors</h1>
				<!-- <table>
					<tr><th>Name</th><th>Value</th></tr> -->
					<pre><?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh sensors'); ?></pre>
				<!-- </table> -->
			</div>
		</div>
	</body>
</html>