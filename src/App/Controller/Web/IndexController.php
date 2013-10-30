<?php

namespace App\Controller\Web;

use Component\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        return $this->render();
    }
}