<?php

namespace App\Model;

use App\Dao\UserDao;

class UserModel {
    protected $dao;

    public function __construct () {
        $this->dao = new UserDao();
    }
}