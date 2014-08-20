<?php

use Symfony\Component\ClassLoader\ApcClassLoader;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

if (extension_loaded('apc') && ini_get('apc.enabled') == '1') {
    $apcLoader = new ApcClassLoader(__DIR__, $loader);
    $loader->unregister();
    $apcLoader->register(true);
}

$debugMode = !isset($_SERVER['HTTP_CLIENT_IP'])
    && !isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    && in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1', '192.168.56.1'));

use App\HttpApp;

$app = new HttpApp (__DIR__ . '/../app', $debugMode);

$app->run();