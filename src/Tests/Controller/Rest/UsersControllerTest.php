<?php

namespace App\Tests\Controller\Rest;

use TestTools\TestCase\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;

class UsersControllerTest extends UnitTestCase
{
    /**
     * @var \App\Controller\Rest\UsersController
     */
    protected $controller;

    public function setUp()
    {
        $this->controller = $this->get('controller.rest.users');
    }

    public function testCgetAction()
    {
        $request = Request::create('http://localhost/users?count=2&offset=0', 'GET');

        $result = $this->controller->cgetAction($request);

        $expected = array(
            0 =>
                array(
                    'user_id' => '1',
                    'email' => 'admin@example.com',
                    'password_reset_token' => '',
                    'firstname' => 'Admin',
                    'lastname' => 'Example',
                    'admin' => true,
                    'created' => '2014-08-04 06:51:35',
                    'updated' => '2014-08-04 06:51:35',
                ),
            1 =>
                array(
                    'user_id' => '2',
                    'email' => 'user@example.com',
                    'password_reset_token' => '',
                    'firstname' => 'User',
                    'lastname' => 'Example',
                    'admin' => false,
                    'created' => '2014-08-04 06:51:35',
                    'updated' => '2014-08-04 06:51:35',
                ),
        );

        $this->assertEquals($expected, $result->getAllResultsAsArray());
    }

    public function testGetAction()
    {
        $result = $this->controller->getAction(1);

        $expected = array(
            'user_id' => '1',
            'email' => 'admin@example.com',
            'password_reset_token' => '',
            'firstname' => 'Admin',
            'lastname' => 'Example',
            'admin' => true,
            'created' => '2014-08-04 06:51:35',
            'updated' => '2014-08-04 06:51:35',
        );

        $this->assertEquals($expected, $result);
    }

    public function testDeleteAction()
    {
        $this->assertNull($this->controller->deleteAction(2));
    }
}