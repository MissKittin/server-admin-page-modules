<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('jquery.php'); ?>
<?php // jquery imports ?>
<!--[if !IE]><!--><script type="text/javascript" src="<?php echo $system['location_html']; ?>/lib/jquery.js"></script><!--<![endif]-->
<!--[if IE]><script type="text/javascript" src="<?php echo $system['location_html']; ?>/lib/jquery-old.js"></script><![endif]-->
