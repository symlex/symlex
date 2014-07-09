<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http;

$app = new Http (__DIR__ . '/../app', true);

$app->run();