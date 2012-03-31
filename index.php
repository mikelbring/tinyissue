<?php
define('LARAVEL_START', microtime(true));

// --------------------------------------------------------------
// The path to the application directory.
// --------------------------------------------------------------
$application = './app/application';

// --------------------------------------------------------------
// The path to the Laravel directory.
// --------------------------------------------------------------
$laravel = './app/laravel';

// --------------------------------------------------------------
// The path to the public directory.
// --------------------------------------------------------------
$public = __DIR__;

require $laravel.'/laravel.php';