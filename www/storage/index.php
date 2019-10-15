<?php include($system_location_php . '/lib/login/login.php'); ?>
<?php include('config.php'); ?>
<?php chdir($system_location_php); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Storage</title>
		<?php include($system_location_php . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			table {
				border: 1px solid #000000;
			}
			.bar-out {
				height: 5px;
				width: 100px;
				border: 1px solid #000000;
				margin: 0;
				padding: 0;
			}
			.bar {
				left: 0;
				height: 5px;
				/* add width: Npx; to local styles */
				margin: 0;
				padding: 0;
			}
		</style>
		<script type="text/javascript">
			function start()
			{
				var RamBarUsageColor=document.getElementById("ram-bar-usage").style.backgroundColor;
				document.getElementById("ram-usage").style.color=RamBarUsageColor;

				return;
			}
		</script>
	</head>
	<body onLoad="javascript:start();">
		<?php include($system_location_php . '/lib/header.php'); ?>
		<div>
			<?php include($system_location_php . '/lib/menu/menu.php'); ?>
			<div id="content">
				<h1>Storage</h1>
				<table>
					<tr><th>Disk/Part</th><th>Size</th><th>Used</th><th>Avail</th><th>Dev</th><th>Percentage</th><th>Used</th></tr>
					<?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh disk_usage'); ?>
				</table>
				<h1>RAM disks</h1>
				<table>
					<tr><th>TmpFs</th><th>Size</th><th>Used</th><th>Avail</th><th>Percentage</th><th>Used</th></tr>
					<?php
						foreach($ram_disks as $ram_disk)
							echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh disk_usage ' . $ram_disk . ' nodev');
					?>
				</table>
				<h1>RAM usage</h1>
				<table>
					<tr><th>Type</th><th>Used</th><th>Total</th><th>Shr</th><th>Buff</th><th>Cchd</th><th>Percentage</th></tr>
					<?php echo shell_exec($system_location_php . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh ram_usage'); ?>
				</table>
			</div>
			<br>
		</div>
	</body>
</html>