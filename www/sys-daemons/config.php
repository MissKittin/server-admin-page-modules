<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('config.php'); ?>
<?php
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