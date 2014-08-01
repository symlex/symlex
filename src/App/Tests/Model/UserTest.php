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

        $this->assertEquals(1, $this->model->getId());
        $this->assertEquals(1, $this->model->admin);
        $this->assertEquals('Admin', $this->model->firstname);
        $this->assertEquals('Silex', $this->model->lastname);
        $this->assertEquals('admin@example.com', $this->model->email);
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
     * @expectedException \Sympathy\Db\Exception
     */
    public function testGetPasswordException() {
        $this->model->password;
    }

    public function testSetPassword() {
        $password = 'fooBar';

        $this->model->setPassword($password);

        $this->assertRegExp('/[\/\$a-zA-Z0-9]+/', $this->model->password);

        $this->assertEquals(crypt($password, $this->model->password), $this->model->password);
    }

    public function testSetEmptyPassword()
    {
        $this->model->findByCredentials('admin@example.com', 'passwd');

        $expected = '$6$5ygXjBO2gNbW$p1eaS7isBLD1JfN6PaQzrGKJHf9UGmUOBCZiqq3VnhDSPhdbIzOnu3kbKO2mcKEFiD11jFoPE5YSyvA7cYbbK1';
        $this->assertEquals($expected, $this->model->password);
        $this->model->setPassword('');
        $this->assertEquals($expected, $this->model->password);
    }
}