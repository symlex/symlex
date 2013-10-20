<?php

use Silex\Application as Silex;

$app['app.name'] = 'Silex';
$app['app.version'] = Silex::VERSION;

$app['db.options'] = array(
    'driver' => 'mysqli',
    'host' => '127.0.0.1',
    'dbname' => 'silex',
    'user' => 'silex',
    'password' => 'silex',
    'port' => null,
    'unix_socket' => null,
//    'wrapperClass' => '\Store\SqlConnection'
);