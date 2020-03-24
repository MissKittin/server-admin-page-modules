<?php
	// functions
	function search_recursive($dir, $regexp)
	{
		$return_array=array();
		$files=scandir($dir);
		foreach($files as $file)
			if(($file != '.') && ($file != '..'))
			{
				if(is_dir($dir . '/' . $file))
					$return_array=array_merge($return_array, search_recursive($dir . '/' . $file, $regexp));
				else
					if(preg_match($regexp, $file))
						array_push($return_array, $dir . '/' . $file);
			}
		return $return_array;
	}
	function opcache_control($system)
	{
		foreach(search_recursive($system['location_php'], '/\.(?:php)$/') as $file)
			if(
				(strpos($file, '/lib/console') === false) && // ignore console tools
				(!is_link($file)) && // ignore links
				(strpos($file, '/lib/opcache.php') === false) // ignore this file
			)
			{
				// notify or compile
				if(opcache_is_script_cached($file))
					echo '[cached] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
				else
				{
					if(isset($_GET['compile']))
					{
						opcache_compile_file($file);
						echo '[compiled] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
					}
					else
						echo '[uncached] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
				}
			}
	}

	if($_SERVER['REMOTE_ADDR'] === '127.0.0.1')
	{
		// on-boot precaching
		header('Content-Type: text/plain');
		opcache_control($system);
	}
	else
	{
		// control opcache from web page
		include($system['location_php'] . '/lib/login/login.php');
		chdir($system['location_php']);
?>
<?php
	// buttons
	if((csrf_checkToken('post')) && (!isset($_POST['reload'])))
	{
		if(isset($_POST['compile'])) $_GET['compile']=true;
		if(isset($_POST['clear'])) opcache_reset();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Opcache</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Opcache</h1>
				<form action="opcache.php" method="post">
					<button name="compile">Compile</button>
					<button name="clear">Clear</button>
					<button name="reload">Reload</button>
					<?php echo csrf_injectToken(); ?>
				</form>
				<hr><div><pre><?php opcache_control($system); ?></pre></div>
				<hr><div><pre><?php var_dump(opcache_get_status()); ?></pre></div>
			</div>
		</div>
	</body>
</html>
<?php } ?>