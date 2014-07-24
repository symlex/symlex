<?php

namespace App\Router;

use App\Model\Session;
use Sympathy\Silex\Router\TwigRouter as SympathyTwigRouter;

class TwigRouter extends SympathyTwigRouter
{
    public function setSession(Session $session)
    {
        $this->twig->addGlobal('user_id', $session->getUserId());
        $this->twig->addGlobal('csrf_token', $session->getCsrfToken());
        $this->twig->addGlobal('firstname', $session->getUserFirstname());
        $this->twig->addGlobal('lastname', $session->getUserLastname());
        $this->twig->addGlobal('is_admin', $session->userIsAdmin());
    }
}