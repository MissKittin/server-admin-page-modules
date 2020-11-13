<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.min.php'); ?>
<?php header('Content-Type: text/css; X-Content-Type-Options: nosniff;'); ?>
<?php /* minifier: https://csscompressor.com */ ?>
.bar-out{background-color:#000;height:5px;width:100px;border:1px solid var(--content_border-color);margin:0;padding:0}.bar-in{background-color:#fff;left:0;height:5px;margin:0;padding:0}