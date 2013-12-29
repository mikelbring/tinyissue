<?php

/* Redirect if we have not installed */
if (!file_exists(__DIR__.'/config.app.php'))
{
    header('Location: ./install/index.php');
}

require __DIR__.'/bootstrap/autoload.php';

$app = require_once __DIR__.'/bootstrap/start.php';
$app->run();
