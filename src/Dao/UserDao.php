<?php

namespace App\Dao;

use Doctrine\ActiveRecord\Dao\Format;

class UserDao extends DaoAbstract
{
    protected $_tableName = 'users';
    protected $_primaryKey = 'user_id';
    protected $_timestampEnabled = true;
    protected $_formatMap = array(
        'admin' => Format::INT
    );
}