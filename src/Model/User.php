<?php

namespace App\Model;

use App\Exception\DuplicateException;
use App\Exception\InvalidArgumentException;
use App\Exception\LogicException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * @see http://docs.symlex.org/en/latest/doctrine-active-record/
 */
class User extends ModelAbstract
{
    protected string $_daoName = 'User';

    public function updatePassword(string $password)
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password is too short');
        }

        // @codeCoverageIgnoreStart
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->getDao()->userPassword = $hash;
        $this->getDao()->userPasswordResetToken = null;
        $this->getDao()->userVerificationToken = null;
        $this->getDao()->update();
    }

    // @codeCoverageIgnoreEnd

    public function findByPasswordResetToken(string $token)
    {
        return $this->find(array('userPasswordResetToken' => $token));
    }

    public function findByVerificationToken(string $token)
    {
        return $this->find(array('userVerificationToken' => $token));
    }

    public function findByEmail(string $email)
    {
        return $this->find(array('userEmail' => $email));
    }

    public function verify()
    : self {
        if ($this->getDao()->userVerificationToken) {
            $this->getDao()->userVerificationToken = null;
            $this->getDao()->update();
        }

        return $this;
    }

    public function isVerified()
    {
        return empty($this->userVerificationToken);
    }

    public function setPasswordResetToken(string $token)
    : self {
        if (strlen($token) < 5) {
            throw new InvalidArgumentException('Password reset token is too short');
        }

        $this->getDao()->userPasswordResetToken = $token;
        $this->getDao()->update();

        return $this;
    }

    public function getPasswordResetToken(): string
    {
        $result = $this->getDao()->userPasswordResetToken;

        if(empty($result)) {
            throw new LogicException('Password reset token is empty');
        }

        return $result;
    }

    public function deletePasswordResetToken()
    : self {
        if ($this->getDao()->userPasswordResetToken) {
            $this->getDao()->userPasswordResetToken = null;
            $this->getDao()->update();
        }

        return $this;
    }

    public function setVerificationToken(string $token)
    : self {
        if (strlen($token) < 5) {
            throw new InvalidArgumentException('Verification token is too short');
        }

        $this->getDao()->userVerificationToken = $token;
        $this->getDao()->update();

        return $this;
    }

    public function getVerificationToken(): string
    {
        $result = $this->getDao()->userVerificationToken;

        if(empty($result)) {
            throw new LogicException('Verification token is empty');
        }

        return $result;
    }

    public function deleteVerificationToken()
    : self {
        if ($this->getDao()->userVerificationToken) {
            $this->getDao()->userVerificationToken = null;
            $this->getDao()->update();
        }

        return $this;
    }

    public function passwordIsValid(string $password)
    : bool {
        return password_verify($password, $this->userPassword);
    }

    public function hasRole(string $role)
    : bool {
        return $this->userRole === $role;
    }

    public function getRole(): string
    {
        return $this->userRole;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isUser()
    {
        return $this->hasRole('user');
    }

    public function save(array $values) {
        try {
            $result = parent::save($values);

            return $result;
        } catch (UniqueConstraintViolationException $e) {
            throw new DuplicateException('User already exists');
        }
    }
}