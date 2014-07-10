<?php

namespace App\Rest;

use Component\Controller\AbstractController;

class UserController extends AbstractController
{
    public function getAction($id)
    {
        $result = array('id' => $id);

        return $result;
    }
}