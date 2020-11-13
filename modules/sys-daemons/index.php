<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/sys-daemons/shell.sh';
	include('config.php');
?>
<?php chdir($system['location_php']); ?>
<?php
	// list generator
	function generate_user_daemons()
	{
		global $shell_sh_location;
		global $system;
		echo '<form action="sys-daemons?userdaemon" method="post">';

		global $user_daemons;
		foreach($user_daemons as $daemonName=>$daemonValue)
		{
			echo '<tr><td>' . $daemonName . '</td><td>';
			foreach($daemonValue['buttons'] as $buttonLabel=>$buttonCommand)
				echo '<input type="submit" class="system_button" name="' . $daemonName . '" value="' . $buttonLabel . '"> ';
			echo '</td><td>' . shell_exec($shell_sh_location . ' user_service status ' . $daemonValue['status']) . '</td></tr>';
		}

		echo csrf_injectToken() . '</form>';
	}

	// command parser
	if((csrf_checkToken('post')) && (isset($_GET['userdaemon'])))
	{
		foreach($user_daemons as $daemonName=>$daemonValue)
			if(isset($_POST[$daemonName]))
			{
				$shell_output=shell_exec($shell_sh_location . ' user_service ' . $daemonValue['buttons'][$_POST[$daemonName]]);
				// $parser_done=true not needed here
				break;
			}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Daemons</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			table { border: 1px solid var(--content_border-color); }
			td { white-space: nowrap; }
		</style>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Daemons</h1>
				<div><table><tr>
					<?php generate_user_daemons(); ?>
				</tr></table></div>
				<div><?php if(isset($shell_output)) echo $shell_output; ?></div>
			</div>
		</div>
	</body>
</html>