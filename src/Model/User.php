<?php

namespace App\Model;

use App\Exception\InvalidArgumentException;
use App\Exception\InvalidPasswordException;
use App\Exception\NotFoundException;

/**
 * @see https://github.com/lastzero/doctrine-active-record
 */
class User extends ModelAbstract
{
    protected $_daoName = 'User';

    public function updatePassword($password)
    {
        if ($password == '') {
            throw new InvalidArgumentException ('Password can not be empty');
        };

        if (!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password)) {
            throw new InvalidArgumentException ('Password is not secure');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->getDao()->password = $hash;
        $this->getDao()->update();
    }

    public function findByPasswordResetToken($token)
    {
        $users = $this->findAll(array('password_reset_token' => $token));

        if (count($users) != 1) {
            throw new InvalidArgumentException ('Invalid password reset token');
        }

        return $users[0];
    }

    public function findByEmail($email)
    {
        $users = $this->findAll(array('email' => $email));

        if (count($users) != 1) {
            throw new InvalidArgumentException('User not found: ' . $email);
        }

        return $users[0];
    }

    public function getPasswordResetToken()
    {
        $token = sha1(random_bytes(32));

        $this->getDao()->password_reset_token = $token;
        $this->getDao()->update();

        return $token;
    }

    public function deletePasswordResetToken()
    {
        if ($this->getDao()->password_reset_token) {
            $this->getDao()->password_reset_token = '';
            $this->getDao()->update();
        }

        return $this;
    }

    public function findByCredentials ($email, $password)
    {
        $matchedUsers = $this->findAll(array('email' => $email));

        $count = count($matchedUsers);

        if ($count == 0) {
            throw new NotFoundException ('User not found');
        } elseif ($count > 1) {
            throw new NotFoundException ('More than one user with this email address found');
        }

        $user = $matchedUsers[0];

        if (!$this->passwordIsValid($user->password, $password)) {
            throw new InvalidPasswordException ('Invalid password');
        }

        return $user;
    }

    public function passwordIsValid($encryptedPassword, $password)
    {
        return password_verify($password, $encryptedPassword);
    }
}