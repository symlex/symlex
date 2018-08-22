<?php

namespace App\Tests\Controller\Rest\V1;

use App\Controller\Rest\V1\UsersController;
use TestTools\TestCase\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\AccessDeniedException;
use App\Service\Session;

class UsersControllerTest extends UnitTestCase
{
    /** @var \App\Controller\Rest\V1\UsersController */
    protected $controller;

    /** @var Session */
    protected $session;

    public function getController(string $email = 'admin@example.com', string $password ='passwd'): UsersController
    {
        $container = $this->getContainer();
        $this->session = $container->get('service.session');
        $this->session->generateToken()->login($email, $password);
        /** @var UsersController $result */
        $result = $container->get('controller.rest.v1.users');

        return $result;
    }

    public function testCgetAction()
    {
        $request = Request::create('http://localhost/users?count=2&offset=0', 'GET');
        $controller = $this->getController();

        $result = $controller->cgetAction($request);

        $users = $result->getAllResultsAsArray();

        foreach ($users as $values) {
            $this->assertArrayHasKey('userId', $values);
            $this->assertArrayHasKey('userEmail', $values);
            $this->assertArrayNotHasKey('userPassword', $values);
            $this->assertArrayHasKey('created', $values);
            $this->assertArrayHasKey('updated', $values);
        }
        $this->assertNotEmpty($users);
    }

    public function testGetAction()
    {
        $controller = $this->getController();

        $result = $controller->getAction(1);

        $this->assertArrayHasKey('userId', $result);
        $this->assertArrayHasKey('userEmail', $result);
        $this->assertArrayNotHasKey('userPassword', $result);
        $this->assertArrayHasKey('created', $result);
        $this->assertArrayHasKey('updated', $result);
    }

    public function testOptionActionWhenUserIsNew()
    {
        $request = Request::create('https://localhost/api/users');
        $controller = $this->getController();

        $form = $controller->optionsAction('new', $request);
        $this->assertArrayHasKey('userFirstName', $form);
        $this->assertArrayHasKey('userLastName', $form);
        $this->assertArrayHasKey('userEmail', $form);
    }

    public function testTryToChangePasswordForOtherUser()
    {
        $request = Request::create('https://localhost/api/v1/users/1/changepassword');
        $controller = $this->getController('user@example.com', 'passwd');

        $this->expectException(AccessDeniedException::class);
        $controller->cputPasswordAction(1, $request);
    }

    public function testCoptionsProfileAction()
    {
        $controller = $this->getController();

        $form = $controller->coptionsProfileAction('1');
        $this->assertArrayHasKey('userFirstName', $form);
        $this->assertArrayHasKey('userLastName', $form);
        $this->assertArrayHasKey('userEmail', $form);
    }
}