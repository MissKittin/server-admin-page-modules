<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('favicon.php'); ?>
<?php $favicon_location=$system['location_html'] . '/lib/favicon'; ?>

<!-- define favicon meta here -->

<?php unset($favicon_location); // clear environment ?>