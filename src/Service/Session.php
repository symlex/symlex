<?php

namespace App\Service;

use App\Model\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Session
{
    protected $session;
    protected $user;

    public function __construct(SessionInterface $session, User $user)
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

        return $this;
    }

    public function login($email, $password)
    {
        $user = $this->user->findByCredentials($email, $password);
        $user->deletePasswordResetToken();

        $this->user = $user;

        $this->session->set('user_id', $this->user->getId());

        return $this;
    }

    public function logout()
    {
        $this->session->clear();
        $this->user = $this->user->createModel();
        $this->initCsrfToken();

        return $this;
    }

    public function generateToken(): string
    {
        $result = sha1(random_bytes(32));

        return $result;
    }

    public function getUserId()
    {
        return $this->session->get('user_id');
    }

    public function getCsrfToken(): string
    {
        return $this->session->get('csrf_token');
    }

    public function getUserFirstname(): string
    {
        $result = $this->user->hasId() ? $this->user->firstname : '';

        return $result;
    }

    public function getUserLastname(): string
    {
        $result = $this->user->hasId() ? $this->user->lastname : '';

        return $result;
    }

    public function isAnonymous(): bool
    {
        return !$this->user->hasId();
    }

    public function isUser(): bool
    {
        return $this->user->hasId();
    }

    public function isAdmin(): bool
    {
        return ($this->isUser() && $this->user->admin);
    }
}