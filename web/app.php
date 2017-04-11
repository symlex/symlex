<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Kernel\WebApp;

$debugMode = strpos($_SERVER['HTTP_HOST'], '-debug') !== false;

$app = new WebApp (__DIR__ . '/../app', $debugMode);

$app->run();