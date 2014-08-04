<?php

namespace App\Dao;

class UserDao extends DbDao
{
    protected $_tableName = 'users';
    protected $_primaryKey = 'user_id';
    protected $_timestampEnabled = true;
}