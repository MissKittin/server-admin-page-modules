<?php
	// update shebangs in scripts
	// only *.sh files will be modified
	// you can force shebang path by typing php update-shebang.php /path/to/document_root
	echo PHP_EOL;

	$superuser_filename='/lib/shell/superuser.sh';
	$superuser_indicator='#?php has_superuser_shebang'; // required on the second line
	$update_shebang_filename='update-shebang.php';

	if(isset($_SERVER['REQUEST_URI'])){ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }

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
	function change_shebang($file, $path, $superuser_path, $file_content)
	{
		echo '[Checking] ' . str_replace($path, '', $file) . PHP_EOL;
		$path=$path . $superuser_path; // new superuser path
		$file_shebang=str_replace('#!', '', $file_content[0]); // remove magic number
		$file_shebang=explode(' ', $file_shebang); // extract current superuser path
		$file_shebang=str_replace($file_shebang[0], $path, $file_content[0]); // create new shebang
		if($file_content[0] !== $file_shebang) // check if edit is needed
		{
			echo '[Updating] ' . $file . PHP_EOL;
			file_put_contents($file, str_replace($file_content[0], $file_shebang, file_get_contents($file)));
		}
	}
	function stdin($hide=false)
	{
		// usage: echo 'Type something: '; $output=stdin(); echo PHP_EOL;
		// or: echo 'Type something: '; $output=stdin(true); echo PHP_EOL;
		if($hide) shell_exec('stty -echo');
		$stdin=fopen('php://stdin', 'r');
		$output=fgets($stdin);
		fclose($stdin);
		if($hide) shell_exec('stty echo');
		return trim($output);
	}

	$new_document_root=realpath(str_replace($update_shebang_filename, '', $_SERVER['SCRIPT_NAME']) . '../..');
	if(isset($argv[1]))
	{
		echo 'Apply custom path? (y/[n]) '; $answer=stdin(); echo PHP_EOL;
		if($answer === 'y')
			$new_document_root=$argv[1];
	}

	echo 'Checking in ' . $new_document_root . PHP_EOL;
	foreach(search_recursive($new_document_root, '/\.(?:sh)$/') as $file)
	{
		$file_content=file($file);
		if(substr($file_content[0], 0, 2) === '#!') // check magic number
			if(str_replace(PHP_EOL, '', $file_content[1]) === $superuser_indicator)
				change_shebang($file, $new_document_root, $superuser_filename, $file_content);
	}
	echo 'Done!' . PHP_EOL;

	echo PHP_EOL;
?>