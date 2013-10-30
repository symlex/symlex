<?php

namespace Component\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

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

    protected function init()
    {
        // Do nothing by default
    }

    protected function render($template = 'index.twig', array $values = array(), $httpCode = 200)
    {
        $result = $this->app['twig']->render($template, $values);

        return new Response($result, $httpCode);
    }

    protected function json(array $values, $httpCode = 200)
    {
        return $this->app->json($values, $httpCode);
    }
}