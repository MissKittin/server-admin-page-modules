<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php
	$superuser=$system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh superuser '; // built-in helper
	$getlog=$system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh getlog '; // built-in helper
	include('config.php');
	ksort($logs);
?>
<?php chdir($system['location_php']); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Logs</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Logs</h1>
				<div id="log-links">
					<?php
						foreach($logs as $log_name=>$log_cmds)
							echo '<a href="sys-logs?log=' . $log_name . '" class="content_noDecorations">' . $log_name . '</a><br>';
					?>
				</div>
				<div id="log-content">
					<pre><?php
						if(isset($_GET['log']))
							if(isset($logs[$_GET['log']]))
								foreach($logs[$_GET['log']] as $log_cmd)
									echo shell_exec($log_cmd);
					?></pre>
				</div>
			</div>
		</div>
	</body>
</html>