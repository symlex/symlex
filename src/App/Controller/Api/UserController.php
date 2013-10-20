<?php

namespace App\Controller\Api;

use Component\Controller\AbstractController;

class UserController extends AbstractController
{
    public function getAction($id)
    {
        $result = array('id' => $id);

        return $this->app->json($result);
    }
}