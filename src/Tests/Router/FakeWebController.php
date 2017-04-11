<?php

namespace App\Tests\Router;

use Symfony\Component\HttpFoundation\Request;

class FakeWebController
{
    public $actionName;
    public $request;

    public function indexAction(Request $request)
    {
        $this->actionName = 'indexAction';
        $this->request = $request;

        return array('actionName' => $this->actionName, 'request' => $request);
    }

    public function postIndexAction(Request $request)
    {
        $this->actionName = 'postIndexAction';
        $this->request = $request;

        return array('actionName' => $this->actionName, 'request' => $request);
    }

    public function fooAction($id, Request $request)
    {
        $this->actionName = 'fooAction';
        $this->request = $request;

        return array('actionName' => $this->actionName, 'id' => $id, 'request' => $request);
    }
}