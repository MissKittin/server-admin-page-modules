<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>System updates</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			#updateobject {
				height: 800px;
				width: 600px;
			}
		</style>
		<script type="text/javascript">
			function update()
			{
				document.getElementById('eol').style.visibility = "hidden";
				document.getElementById('update').style.height="800px";
				document.getElementById('update').style.width="600px";
				document.getElementById("update").innerHTML='<object id="updateobject" type="text/html" data="<?php echo $system['location_html']; ?>/sys-updates/shell.php?shell-command=apt-update"></object>';
			}
		</script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>System updates</h1>
				Last update: <?php echo shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh last-update'); ?> <button class="system_button" onclick="javascript:update();">Update</button><br><br>
				<span style="font-size: 20px;">
					<?php echo shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh updates'); ?>
				</span><br><br>
				<div id="eol" style="position: absolute; bottom: 0px;">
					<span style="font-weight: bold;">End of life: <?php echo shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh system-eol'); ?></span>
				</div>
				<div id="update">
					<!-- reserved for apt-get update -->
				</div>
			</div>
		</div>
	</body>
</html>