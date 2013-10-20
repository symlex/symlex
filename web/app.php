<?php

ini_set('display_errors', 1);

define('APP_ENV', 'prod');

$app = require_once __DIR__.'/../app/bootstrap.php';

$app->run();