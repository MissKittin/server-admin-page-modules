<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('config.php'); ?>
<?php

	$logs=array(
		'acpid-suspend.log' => [$getlog . '/tmp/.acpid-suspend.log'],

		'dmesg' => [$superuser . '/bin/dmesg'],
		'lspci' => [
			$superuser . '/usr/bin/lspci',
			'echo "</pre><hr><pre>"',
			$superuser . '/usr/bin/lspci -vvv | sed -e "s/</(/g" | sed -e "s/>/)/g"'
		]
	);
?>