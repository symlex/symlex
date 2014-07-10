<?php

namespace App\Rest;

class UserController
{
    public function getAction($id)
    {
        $result = array('id' => $id);

        return $result;
    }
}