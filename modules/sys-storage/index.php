<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php include('config.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	// cache result for Storage and RAM Disks
	$shell_sh_location=$system['location_php'] . '/sys-storage/shell.sh';
	$disk_usage_query=shell_exec($shell_sh_location . ' disk_usage');

	// tables rendering
	function output2array($input, $correct_explode) // helper for parse_*_usage()
	{
		$i=0;
		foreach(array_filter(explode(PHP_EOL, $input)) as $value)
		{
			// skip output header
			if($i !== 0)
			{
				// convert output to array, remove empty fields and reset array keys
				$array[$i]=array_values(array_filter(explode(' ', $value), function($val){ return ($val !== ''); }));

				// correct wrongly exploded paths - merge it to field no 5 (only for parse_disk_usage())
				if($correct_explode)
				{
					$x=6;
					while(isset($array[$i][$x]))
					{
						$array[$i][5].=' ' . $array[$i][$x];
						// unset($array[$i][$x]); // this can be here, but it is unnecessary
						++$x;
					}
				}
			}
			++$i;
		}

		return $array;
	}
	function parse_disk_usage($input)
	{
		// output2array to table
		foreach(output2array($input, true) as $value)
			if(strpos($value[0], '/dev/') !== false) // allow only /dev/*
				echo '<tr>
					<td>' . $value[5] . '</td>
					<td>' . $value[1] . '</td>
					<td>' . $value[2] . '</td>
					<td>' . $value[3] . '</td>
					<td>' . $value[0] . '</td>
					<td></td>
					<td>' . $value[4] . '</td>
				</tr>';
	}
	function parse_ramdisk_usage($input, $filter)
	{
		// output2array to table
		foreach(output2array($input, true) as $value)
			foreach($filter as $filter_value)
				if($filter_value === $value[0])
					echo '<tr>
						<td>' . $value[5] . '</td>
						<td>' . $value[1] . '</td>
						<td>' . $value[2] . '</td>
						<td>' . $value[3] . '</td>
						<td></td>
						<td>' . $value[4] . '</td>
					</tr>';
	}
	function parse_ram_usage($input)
	{
		// output2array to table
		foreach(output2array($input, false) as $value)
			if($value[0] === 'Mem:')
				echo '<tr>
					<td>' . $value[0] . '</td>
					<td>' . $value[2] . '</td>
					<td>' . $value[1] . '</td>
					<td>' . $value[4] . '</td>
					<td>' . $value[5] . '</td>
					<td>' . $value[6] . '</td>
					<td></td>
				</tr>';
			else if(($value[0] === 'Swap:') && ($value[1] !== '0')) // don't display swap when is disabled
				echo '<tr>
					<td>' . $value[0] . '</td>
					<td>' . $value[2] . '</td>
					<td>' . $value[1] . '</td>
					<td></td><td></td>
					<td>' . $value[3] . '</td>
					<td></td>
				</tr>';
			// ignore rest lines
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Storage</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $system['location_html']; ?>/sys-storage/style">
		<script src="<?php echo $system['location_html']; ?>/sys-storage/script"></script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Storage</h1>
				<table>
					<tr><th>Disk/Part</th><th>Size</th><th>Used</th><th>Avail</th><th>Dev</th><th><!-- Percentage --></th><th>Used</th></tr>
					<?php parse_disk_usage($disk_usage_query); ?>
				</table>
				<h1>RAM disks</h1>
				<table>
					<tr><th>TmpFs</th><th>Size</th><th>Used</th><th>Avail</th><th><!-- Percentage --></th><th>Used</th></tr>
					<?php parse_ramdisk_usage($disk_usage_query, $ram_disks); ?>
				</table>
				<h1>RAM usage</h1>
				<table>
					<tr><th>Type</th><th>Used</th><th>Total</th><th>Shr</th><th>Cchd</th><th>Avail</th><th><!-- Percentage --></th></tr>
					<?php parse_ram_usage(shell_exec($shell_sh_location . ' ram_usage')); ?>
				</table>
			</div>
			<br>
		</div>
	</body>
</html>