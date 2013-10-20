<?php

namespace App\Controller\Web;

use Component\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        return $this->app['twig']->render('index.twig', array());
    }

    public function exceptionAction()
    {
        throw new \InvalidArgumentException('Foo Bar');
    }
}