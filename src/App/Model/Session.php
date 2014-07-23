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

        $userId = $this->session->get('user_id');

        if($userId) {
            $this->user->find($userId);
        }
    }

    public function login($email, $password)
    {
        $this->user->findByCredentials($email, $password);

        $this->session->set('user_id', $this->user->getId());
    }
}