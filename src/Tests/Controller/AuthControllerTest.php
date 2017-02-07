<?php

namespace App\Tests\Controller;

use TestTools\TestCase\UnitTestCase;

class AuthControllerTest extends UnitTestCase
{
    /**
     * @var \App\Controller\AuthController
     */
    protected $controller;

    public function setUp()
    {
        $this->controller = $this->get('controller.web.auth');
    }

    public function testLoginAction()
    {
        $result = $this->controller->loginAction();

        $expected = array(
            'page_name' => 'Login'
        );

        $this->assertEquals($expected, $result);
    }

    public function testResetAction () {
        $result = $this->controller->resetAction();

        $expected = array('email' => '', 'error' => false, 'success' => false, 'page_name' => 'Reset Password');

        $this->assertEquals($expected, $result);
    }

    public function testLogoutAction () {
        $result = $this->controller->logoutAction();

        $expected = '/';

        $this->assertEquals($expected, $result);
    }
}