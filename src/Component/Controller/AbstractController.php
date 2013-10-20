<?php

namespace Component\Controller;

use Silex\Application;

abstract class AbstractController
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->init();
    }

    protected function init() {
        // Do nothing by default
    }
}