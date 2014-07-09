<?php

namespace Component\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

abstract class AbstractController
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    protected $twig;

    public function __construct(Application $app, Twig_Environment $twig)
    {
        $this->app = $app;
        $this->twig = $twig;
        $this->init();
    }

    protected function init()
    {
        // Do nothing by default
    }

    protected function render($template = 'index.twig', array $values = array(), $httpCode = 200)
    {
        $result = $this->twig->render($template, $values);

        return new Response($result, $httpCode);
    }

    protected function json(array $values, $httpCode = 200)
    {
        return $this->app->json($values, $httpCode);
    }
}