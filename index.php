<?php

/* Redirect if we have not installed */
if(!file_exists(__DIR__ . 'config.app.php'))
{
	header('Location: ./install');
}

define('LARAVEL_START', microtime(true));
$web = true;
require 'app/paths.php';
unset($web);

require path('sys').'laravel.php';