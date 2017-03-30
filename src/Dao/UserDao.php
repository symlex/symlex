<?php

namespace App\Dao;

use Doctrine\ActiveRecord\Dao\Format;

/**
 * @see https://github.com/lastzero/doctrine-active-record
 */
class UserDao extends DaoAbstract
{
    protected $_tableName = 'users';
    protected $_primaryKey = 'user_id';
    protected $_timestampEnabled = true;

    protected $_formatMap = array(
        'admin' => Format::BOOL
    );

    protected $_hiddenFields = array(
        'password'
    );
}