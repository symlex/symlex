<?php

namespace App\Model;

use App\Exception\InvalidPasswordException;
use App\Exception\NotFoundException;

class User extends DbModel
{
    protected $_daoName = 'User';

    public function setPassword($password)
    {
        if($password == '') return;

        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        $hash = crypt($password, $salt);
        $this->getDao()->password = $hash;
    }

    public function findByCredentials ($email, $password)
    {
        $dao = $this->getDao();
        $matchedUsers = $dao->findAll(array('email' => $email));

        $count = count($matchedUsers);

        if ($count == 0) {
            throw new NotFoundException ('User not found');
        } elseif ($count > 1) {
            throw new NotFoundException ('More than one user with this email address found');
        }

        $user = $matchedUsers[0];
        if (crypt($password, $user->password) != $user->password) {
            throw new InvalidPasswordException ('Invalid password');
        }

        $this->_dao = $user;

        return $this;
    }
}