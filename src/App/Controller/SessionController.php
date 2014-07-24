<?php

namespace App\Controller;

use App\Model\Session;
use Symfony\Component\HttpFoundation\Request;

class SessionController
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function loginAction()
    {
    }

    public function logoutAction()
    {
        $this->session->logout();
        return '/index/index';
    }

    public function postLoginAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $result = array('email' => $email, 'password' => $password, 'error' => '');

        try {
            $this->session->login($email, $password);
            return '/index/index';
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }
}