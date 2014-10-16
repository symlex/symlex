<?php

namespace App\Router;

use App\Service\Session;
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
            $receivedToken = $request->headers->get('X-CSRF-Token');

            if(!$receivedToken) {
                $receivedToken = $request->get('csrf_token');
            }

            $expectedToken = $session->getCsrfToken();

            if($receivedToken != $expectedToken) {
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