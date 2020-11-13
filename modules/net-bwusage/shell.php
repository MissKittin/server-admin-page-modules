<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	// Data provider - parser

	// settings
	$data_provider_backend_location=$system['location_php'] . '/net-bwusage/shell.sh';
	$use_session=true; // treat input from frontend as untrusted

	if((isset($_GET['queryInterfaces'])) && (isset($_GET['interfaces']))) // most used code
	{
		header('Content-Type: application/json');

		if($use_session)
			$input=$_SESSION['net-bwusage_interfaces']; // step 3: just use converted data
		else
		{
			if(strpos($_GET['interfaces'], '\'') === false)
				$input=$_GET['interfaces'];
			else
				$input='';
		}

		$i=0;
		foreach(array_filter(explode(PHP_EOL, shell_exec($data_provider_backend_location . ' queryInterfaces ' . '\''.str_replace('|', ' ', $input).'\''))) as $shellOutput)
		{ $output[$i]=explode('|', $shellOutput); ++$i; }

		echo json_encode($output);
		exit();
	}
	else if(isset($_GET['getInterfaces'])) // read config
	{
		header('Content-Type: application/json');
		if($use_session)
		{
			$output=array_filter(explode(' ', shell_exec($data_provider_backend_location . ' getInterfaces')));
			$_SESSION['net-bwusage_interfaces']=$output; // step 1: save array in session
			echo json_encode($output);
		}
		else
			echo json_encode(array_filter(explode(' ', shell_exec($data_provider_backend_location . ' getInterfaces'))));
		exit();
	}
	else if((isset($_GET['getInterfacesInfo'])) && (isset($_GET['interfaces']))) // parse config
	{
		header('Content-Type: application/json');

		if($use_session)
		{
			$input='';
			foreach($_SESSION['net-bwusage_interfaces'] as $inputValue) $input.=$inputValue . '|';
			$_SESSION['net-bwusage_interfaces']=$input; // step 2: update value with converted array
		}
		else
		{
			if(strpos($_GET['interfaces'], '\'') === false)
				$input=$_GET['interfaces'];
			else
				$input='';
		}

		$i=0;
		foreach(array_filter(explode(PHP_EOL, shell_exec($data_provider_backend_location . ' getInterfacesInfo ' . '\''.str_replace('|', ' ', $input).'\''))) as $shellOutput)
		{ $output[$i]=explode('|', $shellOutput); ++$i; }

		echo json_encode($output);
		exit();
	}
	else
	{ include($system['location_php'] . '/lib/prevent-index.php'); exit(); }
?>