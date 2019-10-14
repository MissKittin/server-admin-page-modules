<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php chdir($system_location_php); ?>
<?php
	if(isset($_POST['sync-system-clock']))
		$ntpdate_output=shell_exec('ntpdate-debian');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Clock</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
				<h1>Clock</h1>
				<form action="sys-clock" method="post">
					<?php echo shell_exec('date "+%d.%m.%Y %H:%M:%S"'); ?>
					<input type="submit" name="sync-system-clock" value="Sync">
				</form>
				<?php if(isset($ntpdate_output)) echo '<h2>Sync result</h2>' . $ntpdate_output; ?>
			</div>
		</div>
	</body>
</html>