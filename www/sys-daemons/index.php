<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/sys-daemons/shell.sh';

	//$dot='.'; // helper for config.php must be defined here
	include('config.php');
?>
<?php chdir($system['location_php']); ?>
<?php
	// list generators
//	function generate_daemons_list()
//	{
//		global $system;
//		echo '<form action="sys-daemons?systemdaemon" method="post">';
//
//		global $daemons_list;
//		foreach($daemons_list as $daemon)
//		{
//			echo '<tr>
//					<td>'. $daemon . '</td>
//					<td>
//						<input type="submit" class="system_button" name="' . $daemon . '" value="Start">
//						<input type="submit" class="system_button" name="' . $daemon . '" value="Restart">
//						<input type="submit" class="system_button" name="' . $daemon . '" value="Stop">
//					</td>
//					<td>' . shell_exec($shell_sh_location . ' check_service ' . $daemon) . '</td>
//				</tr>';
//		}
//
//		echo csrf_injectToken() . '</form>';
//	}
//	function generate_special_daemons_list()
//	{
//		global $system;
//		echo '<form action="sys-daemons?specialdaemon" method="post">';
//
//		global $special_daemons_list;
//		foreach($special_daemons_list as $daemon)
//		{
//			echo '<tr><td>'. $daemon . '</td><td>';
//			global ${"special_daemon_$daemon"};
//			foreach(${"special_daemon_$daemon"} as $button)
//			{
//				if(strpos($daemon, "."))
//					$daemon_name=substr($daemon, 0, strpos($daemon, '.')); // has '.'
//				else
//					$daemon_name=$daemon;
//
//				switch($button)
//				{
//					case 'start':
//						echo '<input type="submit" class="system_button" name="' . $daemon_name . '" value="Start"> '; // spaces at end for pretty look
//						break;
//					case 'restart':
//						echo '<input type="submit" class="system_button" name="' . $daemon_name . '" value="Restart"> ';
//						break;
//					case 'stop':
//						echo '<input type="submit" class="system_button" name="' . $daemon_name . '" value="Stop"> ';
//						break;
//				}
//			}
//			echo '</td><td>' . shell_exec($shell_sh_location . ' check_special_service ' . $daemon) . '</td></tr>';
//		}
//
//		echo csrf_injectToken() . '</form>';
//	}
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

	// command parsers
	if(csrf_checkToken('post'))
	{
//		$parser_done=false;
//		if(isset($_GET['systemdaemon'])) // !$parser_done not needed here
//			foreach($daemons_list as $daemon)
//				if(isset($_POST[$daemon]))
//				{
//					$shell_output=shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . "/shell.sh service $daemon " . strtolower($_POST[$daemon]));
//					$parser_done=true;
//					break;
//				}
//
//		if((isset($_GET['specialdaemon'])) && (!$parser_done))
//			foreach($special_daemons_list as $daemon)
//			{
//				// for names with .sh
//				$daemon_name=substr($daemon, 0, strpos($daemon, '.')); // without .sh
//				if(isset($_POST[$daemon_name]))
//				{
//					$shell_output=shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . "/shell.sh special_service $daemon " . strtolower($_POST[$daemon_name]));
//					$parser_done=true;
//					break;
//				}
//				// for names without .sh
//				if(isset($_POST[$daemon]))
//				{
//					$shell_output=shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . "/shell.sh special_service $daemon " . strtolower($_POST[$daemon]));
//					$parser_done=true;
//					break;
//				}
//			}
//
		//if((isset($_GET['userdaemon'])) && (!$parser_done))
		if(isset($_GET['userdaemon']))
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
					<?php
//						generate_daemons_list();
//						generate_special_daemons_list();
						generate_user_daemons();
					?>
				</tr></table></div>
				<div><?php if(isset($shell_output)) echo $shell_output; ?></div>
			</div>
		</div>
	</body>
</html>