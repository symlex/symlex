<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\HttpApp;

$app = new HttpApp (__DIR__ . '/../app', false);

$app->run();