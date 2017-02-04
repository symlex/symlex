<?php

namespace App\Router;

use Symlex\Router\TwigRouter as SymlexTwigRouter;

class TwigRouter extends SymlexTwigRouter
{
    use SessionTrait;

    protected function setTwigVariables($controller, $action, $isXmlHttpRequest)
    {
        parent::setTwigVariables($controller, $action, $isXmlHttpRequest);

        $this->twig->addGlobal('user_id', $this->session->getUserId());
        $this->twig->addGlobal('csrf_token', $this->session->getCsrfToken());
        $this->twig->addGlobal('firstname', $this->session->getUserFirstname());
        $this->twig->addGlobal('lastname', $this->session->getUserLastname());
        $this->twig->addGlobal('is_admin', $this->session->isAdmin());
        $this->twig->addGlobal('is_anonymous', $this->session->isAnonymous());
    }
}