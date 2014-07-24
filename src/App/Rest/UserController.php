<?php

namespace App\Rest;

use App\Exception\AccessDeniedException;
use App\Model\Session;
use App\Model\User;

class UserController
{
    protected $session;
    protected $user;

    public function __construct(Session $session, User $user)
    {
        $this->session = $session;
        $this->user = $user;

        if (!$this->session->isUser()) {
            throw new AccessDeniedException ('User API can not be used anonymously');
        }
    }

    protected function sanitizeUserValues($values)
    {
        // Never return passwords
        unset($values['password']);

        // Only return these fields if user is admin
        if (!$this->session->isAdmin()) {
            unset($values['created']);
            unset($values['updated']);
            unset($values['email']);
            unset($values['admin']);
        }

        return $values;
    }

    public function cgetAction()
    {
        $users = $this->user->findAll();
        $result = array();

        foreach($users as $user) {
            $result[] = $this->sanitizeUserValues($user->getValues());
        }

        return $result;
    }

    public function getAction($id)
    {
        $this->user->find($id);

        $result = $this->sanitizeUserValues($this->user->getValues());

        return $result;
    }
}