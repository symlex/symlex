<?php

namespace App;

use Sympathy\Bootstrap\App;

class Http extends App
{
    public function __construct($appPath, $debug = false)
    {
        if($debug) {
            ini_set('display_errors', 1);
        }

        parent::__construct('web', $appPath, $debug);
    }

    public function boot () {
        parent::boot();

        $container = $this->getContainer();

        $container->get('router.web')->route();
        $container->get('router.rest')->route();
        $container->get('router.error')->route();
    }
}