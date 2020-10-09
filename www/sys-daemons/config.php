<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('config.php'); ?>
<?php
//	// standalone daemons
//	$daemons_list=array(
//				'acpid',
//				'fancontrol'
//	);
//
//	// special daemons
//	$special_daemons_list=array(
//					'example',
//					'firewall.sh',
//					'notify-daemon.sh',
//					'system-autoupdate.sh'
//	);
//
//	// special daemons buttons - replace '.' with ${dot} , array('none') -> no buttons
//	$special_daemon_example=array('start', 'restart', 'stop');
//	${"special_daemon_firewall${dot}sh"}=array('start');
//	${"special_daemon_notify-daemon${dot}sh"}=array('start', 'stop');
//	${"special_daemon_system-autoupdate${dot}sh"}=array('none');
//
	// user daemons
	$user_daemons=array(
		'acpid'=>array(
			'status'=>'/etc/init.d/acpid status',
			'buttons'=>array(
				'Start'=>'/etc/init.d/acpid start',
				'Restart'=>'/etc/init.d/acpid restart',
				'Stop'=>'/etc/init.d/acpid stop'
			)
		),
		'example'=>array(
			'status'=>'/etc/init.d/example status',
			'buttons'=>array()
		)
	);
?>