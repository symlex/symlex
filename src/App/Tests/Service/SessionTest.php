<?php

namespace App\Tests\Service;

use TestTools\TestCase\UnitTestCase;

class SessionTest extends UnitTestCase
{
    /**
     * @var \App\Service\Session
     */
    protected $model;

    public function setUp()
    {
        $this->model = $this->get('service.session');
    }

    public function testLogin()
    {
        $this->assertNull($this->model->getUserId());
        $this->assertRegExp('/[a-zA-Z0-9]{40}/', $this->model->getCsrfToken());

        $this->model->login('admin@example.com', 'passwd');

        $this->assertEquals(1, $this->model->getUserId());
        $this->assertRegExp('/[a-zA-Z0-9]{40}/', $this->model->getCsrfToken());
    }

    public function testLogout()
    {
        $this->model->login('admin@example.com', 'passwd');
        $this->assertEquals(1, $this->model->getUserId());
        $oldToken = $this->model->getCsrfToken();
        $this->assertRegExp('/[a-zA-Z0-9]{40}/', $oldToken);
        $this->model->logout();
        $newToken = $this->model->getCsrfToken();
        $this->assertRegExp('/[a-zA-Z0-9]{40}/', $newToken);
        $this->assertNull($this->model->getUserId());
    }

    public function testGenerateToken () {
        $token = $this->model->generateToken();
        $this->assertRegExp('/[a-zA-Z0-9]{40}/', $token);
    }

    public function testUser () {
        $this->assertTrue($this->model->isAnonymous());
        $this->assertFalse($this->model->isUser());
        $this->assertFalse($this->model->isAdmin());
        $this->assertEquals('', $this->model->getUserFirstname());
        $this->assertEquals('', $this->model->getUserLastname());

        $this->model->login('user@example.com', 'passwd');

        $this->assertFalse($this->model->isAnonymous());
        $this->assertTrue($this->model->isUser());
        $this->assertFalse($this->model->isAdmin());
        $this->assertEquals('User', $this->model->getUserFirstname());
        $this->assertEquals('Silex', $this->model->getUserLastname());
    }

    public function testAdmin () {
        $this->assertTrue($this->model->isAnonymous());
        $this->assertFalse($this->model->isUser());
        $this->assertFalse($this->model->isAdmin());
        $this->assertEquals('', $this->model->getUserFirstname());
        $this->assertEquals('', $this->model->getUserLastname());

        $this->model->login('admin@example.com', 'passwd');

        $this->assertFalse($this->model->isAnonymous());
        $this->assertTrue($this->model->isUser());
        $this->assertTrue($this->model->isAdmin());
        $this->assertEquals('Admin', $this->model->getUserFirstname());
        $this->assertEquals('Silex', $this->model->getUserLastname());
    }
}