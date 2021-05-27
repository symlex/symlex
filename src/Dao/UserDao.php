<?php

namespace App\Dao;

class UserDao extends DaoAbstract
{
    protected string $_tableName = 'users';
    protected string $_primaryKey = 'userId';
    protected bool $_timestampEnabled = true;

    protected array $_formatMap = [
        'userId' => Format::INT,
        'userRole' => Format::STRING,
        'userNewsletter' => Format::BOOL,
    ];

    protected array $_hiddenFields = [
        'userPassword',
        'userPasswordResetToken',
        'userVerificationToken',
    ];
}
