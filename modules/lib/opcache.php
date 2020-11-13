<?php
	$opcache_status=true;

	// check opcache
	if(!function_exists('opcache_get_status'))
		$no_opcache=true;

	if(!isset($no_opcache))
		if(!@opcache_get_status())
			$no_opcache=true;

	// functions
	function opcache_search_recursive($dir, $regexp)
	{
		$return_array=array();
		$files=scandir($dir);
		foreach($files as $file)
			if(($file != '.') && ($file != '..'))
			{
				if(is_dir($dir . '/' . $file))
					$return_array=array_merge($return_array, opcache_search_recursive($dir . '/' . $file, $regexp));
				else
					if(preg_match($regexp, $file))
						array_push($return_array, $dir . '/' . $file);
			}
		return $return_array;
	}
	function opcache_control($system)
	{
		global $opcache_status;
		$return='';

		foreach(opcache_search_recursive($system['location_php'], '/\.(?:php)$/') as $file)
			if(
				(strpos($file, '/lib/console') === false) && // ignore console tools
				(!is_link($file)) && // ignore links
				(strpos($file, '/lib/opcache.php') === false) // ignore this file
			)
			{
				// notify or compile
				if(opcache_is_script_cached($file))
					$return.='[cached] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
				else
				{
					if(isset($_GET['compile']))
					{
						try
						{
							opcache_compile_file($file);
							$return.='[compiled] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
						} catch(ParseError $e)
						{
							$opcache_status=false;
							$return.='[syntax error] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
						}
					}
					else
					{
						$opcache_status=false;
						$return.='[uncached] ' . str_replace($system['location_php'], '', $file) . PHP_EOL;
					}
				}
			}

		return $return;
	}

	// on-boot precaching
	if(($_SERVER['REMOTE_ADDR'] === '127.0.0.1') && (isset($_GET['autocompile'])))
	{
		header('Content-Type: text/plain');
		if(isset($no_opcache))
		{
			echo 'Opcache disabled';
			exit();
		}
		echo opcache_control($system);
		exit();
	}

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
				<?php if(isset($no_opcache)) { ?>
					<h2>Status: <span style="color: #ff0000; -webkit-text-stroke: 1px #990000;">Disabled</span></h2>
				<?php } else { ?>
					<form action="opcache.php" method="post">
						<button class="system_button" name="compile">Compile</button>
						<button class="system_button" name="clear">Clear</button>
						<button class="system_button" name="reload">Reload</button>
						<?php echo csrf_injectToken(); ?>
					</form>
					<?php
						$opcache_output=opcache_control($system);
						if($opcache_status)
							echo '<h2>Status: <span style="color: #00ff00; -webkit-text-stroke: 1px #009900;">Cached</span></h2>';
						else
							echo '<h2>Status: <span style="color: #ff0000; -webkit-text-stroke: 1px #990000;">Cleaned</span></h2>';
					?>
					<hr><div><pre><?php echo $opcache_output; ?></pre></div>
					<hr><div><pre><?php var_dump(opcache_get_status()); ?></pre></div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>