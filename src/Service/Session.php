<?php

namespace App\Service;

use App\Model\UserModel;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Session
{
    protected $session;
    protected $user;

    public function __construct(SessionInterface $session, UserModel $user)
    {
        $this->session = $session;
        $this->user = $user;

        $this->session->start();

        $userId = $this->getUserId();

        if($userId) {
            $this->user->find($userId);
        }

        $this->initCsrfToken();
    }

    public function initCsrfToken () {
        if(!$this->session->has('csrf_token')) {
            $this->session->set('csrf_token', $this->generateToken());
        }
    }

    public function login($email, $password)
    {
        $user = $this->user->findByCredentials($email, $password);
        $user->deletePasswordResetToken();

        $this->user = $user;

        $this->session->set('user_id', $this->user->getId());
    }

    public function logout()
    {
        $this->session->clear();
        $this->user = $this->user->createModel();
        $this->initCsrfToken();
    }

    public function generateToken()
    {
        $result = sha1(openssl_random_pseudo_bytes(32));
        return $result;
    }

    public function getUserId()
    {
        return $this->session->get('user_id');
    }

    public function getCsrfToken()
    {
        return $this->session->get('csrf_token');
    }

    public function getUserFirstname()
    {
        $result = $this->user->hasId() ? $this->user->firstname : '';
        return $result;
    }

    public function getUserLastname()
    {
        $result = $this->user->hasId() ? $this->user->lastname : '';
        return $result;
    }

    public function isAnonymous()
    {
        return !$this->user->hasId();
    }

    public function isUser()
    {
        return $this->user->hasId();
    }

    public function isAdmin()
    {
        return ($this->isUser() && $this->user->admin);
    }
}