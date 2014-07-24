<?php

namespace App\Router;

use App\Model\Session;
use Symfony\Component\HttpFoundation\Request;

trait SessionTrait
{
    protected $session;

    public function hasPermission(Request $request)
    {
        $method = strtoupper($request->getMethod());
        $session = $this->getSession();

        // Automatic CSRF protection for POST/DELETE/PUT requests
        if($method != 'GET') {
            $actualToken = $request->headers->get('X-CSRF-Token');
            $expectedToken = $session->getCsrfToken();

            if($actualToken != $expectedToken) {
                $session->logout();
                return false;
            }
        }

        return true;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }
}