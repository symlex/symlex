<?php

namespace Controller\Api;

use Controller\AbstractController;

class UserController extends AbstractController
{
    public function getAction($id)
    {
        $result = array('id' => $id);

        return $this->app->json($result);
    }
}