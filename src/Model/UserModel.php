<?php

namespace App\Model;

use App\Exception\EnvironmentException;
use App\Exception\InvalidArgumentException;
use App\Exception\InvalidPasswordException;
use App\Exception\NotFoundException;

/**
 * @see https://github.com/lastzero/doctrine-active-record
 */
class UserModel extends ModelAbstract
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

        if (CRYPT_SHA512 != 1) {
            throw new EnvironmentException ('SHA512 not supported');
        }

        $cost = 6500;
        $salt = strtr(base64_encode($this->getRandomBytes(16)), '+', '.');
        $salt = '$6$rounds=' . $cost . '$' . $salt . '$'; // SHA-512 (6500 rounds)

        $hash = crypt($password, $salt);

        $this->getDao()->password = $hash;
        $this->getDao()->update();
    }

    protected function getRandomBytes ($size) {
        if(function_exists('mcrypt_create_iv')) {
            return mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);
        }

        if(function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($size);
        }

        throw new EnvironmentException ('mcrypt or openssl extension required');
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
        $token = sha1($this->getRandomBytes(32));

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
        return (crypt($password, $encryptedPassword) == $encryptedPassword);
    }
}