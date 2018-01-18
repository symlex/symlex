<?php

namespace App\Traits;

use App\Service\Session;
use Symfony\Component\HttpFoundation\Request;

trait SessionTrait
{
    /** @var Session */
    protected $session;

    public function hasPermission(Request $request): bool
    {
        return true;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }
}