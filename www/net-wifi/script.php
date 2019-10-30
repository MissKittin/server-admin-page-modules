<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php if(!isset($_GET['root'])) { include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('script.php'); } ?>
<?php header('Content-Type: application/javascript'); ?>

$(document).ready(function(){
	/* start app */
	$('#networks-list').load('<?php echo $system['location_html']; ?>/net-wifi/shell.php?wifi');
	console.log('network list preloaded');
	list_refresh();
	console.log('list updating loop started');

	/* refresh button click */
	$("#manualRefresh").click(function(){
		manual_refresh();
	});

	/* disconnect button click */
	$("#disconnect").click(function(){
		$("#nocontent").load('<?php echo $system['location_html'] . $_GET['root']; ?>/shell.php?wifi?disconnect');
		manual_refresh();
	});
});

function list_refresh()
{
	setTimeout(function(){
		if(!$("#password").is(":focus"))
		{
			$('#networks-list').html('<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr><tr><td colspan="4">Scanning...</td></tr></table>');
			$('#networks-list').load('<?php echo $system['location_html'] . $_GET['root']; ?>/shell.php?wifi');
		}
		else
			console.log('password input is focused, not updating');
		list_refresh();
	}, 14400)
}

function manual_refresh()
{
	console.log('updating list manually...');
	$('#networks-list').html('<table><tr><th>Name</th><th>MAC</th><th>Channel</th><th>Range</th></tr><tr><td colspan="4">Scanning...</td></tr></table>');
	$('#networks-list').load('<?php echo $system['location_html'] . $_GET['root']; ?>/shell.php?wifi');
}
