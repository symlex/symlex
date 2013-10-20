<?php

require_once __DIR__.'/../vendor/autoload.php';

if(!defined('APP_ENV')) {
    define('APP_ENV', 'prod');
}

use Silex\Application;

$app = new Application();

require_once __DIR__.'/config/parameters.dist.php';

if(file_exists(__DIR__.'/config/parameters.local.php')) {
    require_once __DIR__.'/config/parameters.local.php';
}

require_once __DIR__.'/bootstrap/' . APP_ENV . '.php';

if(file_exists(__DIR__.'/bootstrap/' . APP_ENV . '.local.php')) {
    require_once __DIR__.'/bootstrap/' . APP_ENV . '.local.php';
}

return $app;