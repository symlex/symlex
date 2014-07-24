<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\Session\Session as SessionHandler;

class Session
{
    protected $session;
    protected $user;

    public function __construct(SessionHandler $session, User $user)
    {
        $this->session = $session;
        $this->user = $user;

        $this->session->start();

        $userId = $this->getUserId();

        if($userId) {
            $this->user->find($userId);
        }
    }

    public function login($email, $password)
    {
        $this->user->findByCredentials($email, $password);

        $this->session->set('user_id', $this->user->getId());
        $this->session->set('csrf_token', $this->generateToken());
    }

    public function logout()
    {
        $this->session->clear();
        $this->user = $this->user->factory();
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

    public function userIsAdmin()
    {
        $result = $this->user->hasId() ? $this->user->admin : 0;
        return $result;
    }
}