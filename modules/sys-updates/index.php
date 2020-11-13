<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php if(!csrf_checkToken('get')){ include($system['location_php'] . '/lib/prevent-index.php'); exit(); } ?>
<?php $shell_sh_location=$system['location_php'] . '/sys-updates/shell.sh'; ?>
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
				document.getElementById("update").innerHTML='<object id="updateobject" type="text/html" data="<?php echo $system['location_html']; ?>/sys-updates/shell.php?shell-command=apt-update&<?php echo csrf_printToken('parameter'); ?>=<?php echo csrf_printToken('value'); ?>"></object>';
			}
		</script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>System updates</h1>
				Last update: <?php echo shell_exec($shell_sh_location . ' last-update'); ?> <button class="system_button" onclick="javascript:update();">Update</button><br><br>
				<span style="font-size: 20px;">
					<?php echo shell_exec($shell_sh_location . ' updates'); ?>
				</span><br><br>
				<!-- <div id="eol" style="position: absolute; bottom: 0px;">
					<span style="font-weight: bold;">End of life: <?php /* echo shell_exec($shell_sh_location . ' system-eol'); */ ?></span>
				</div> -->
				<div id="update" style="border-radius: 5px;">
					<!-- reserved for apt-get update -->
				</div>
			</div>
		</div>
	</body>
</html>