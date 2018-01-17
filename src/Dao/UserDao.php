<?php

namespace App\Dao;

class UserDao extends DaoAbstract
{
    protected $_tableName = 'users';
    protected $_primaryKey = 'userId';
    protected $_timestampEnabled = true;

    protected $_formatMap = [
        'userId' => Format::INT,
        'userRole' => Format::STRING,
        'userNewsletter' => Format::BOOL,
    ];

    protected $_hiddenFields = [
        'userPassword',
        'userPasswordResetToken',
        'userVerificationToken',
    ];
}
