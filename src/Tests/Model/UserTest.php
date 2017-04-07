<?php

namespace App\Tests\Model;

use TestTools\TestCase\UnitTestCase;

class UserTest extends UnitTestCase
{
    /**
     * @var \App\Model\User
     */
    protected $model;

    public function setUp()
    {
        $this->model = $this->get('model.user');
    }

    public function testFind()
    {
        $this->model->find(1);

        $this->assertEquals(1, $this->model->getId());
        $this->assertEquals(1, $this->model->admin);
    }

    public function testFindByCredentials() {
        $result = $this->model->findByCredentials('admin@example.com', 'passwd');

        $this->assertInstanceOf('\App\Model\User', $result);

        $this->assertEquals(1, $result->getId());
        $this->assertEquals(true, $result->admin);
        $this->assertEquals('Admin', $result->firstname);
        $this->assertEquals('Silex', $result->lastname);
        $this->assertEquals('admin@example.com', $result->email);
    }

    /**
     * @expectedException \App\Exception\NotFoundException
     */
    public function testFindByCredentialsNotFound() {
        $this->model->findByCredentials('admin2@example.com', 'passwd');
    }

    /**
     * @expectedException \App\Exception\InvalidPasswordException
     */
    public function testFindByCredentialsInvalidPassword() {
        $this->model->findByCredentials('admin@example.com', 'passwd2');
    }

    /**
     * @expectedException \Doctrine\ActiveRecord\Exception\Exception
     */
    public function testGetPasswordException() {
        $this->model->password;
    }

    /**
     * @expectedException \App\Exception\InvalidArgumentException
     */
    public function testInsecurePassword() {
        $password = 'fooBar';

        $this->model->find(2);

        $this->model->updatePassword($password);
    }

    public function testAdminUser()
    {
        $user = $this->model->findByCredentials('admin@example.com', 'passwd');

        $expected = '$6$5ygXjBO2gNbW$p1eaS7isBLD1JfN6PaQzrGKJHf9UGmUOBCZiqq3VnhDSPhdbIzOnu3kbKO2mcKEFiD11jFoPE5YSyvA7cYbbK1';
        $this->assertEquals($expected, $user->password);
    }
}