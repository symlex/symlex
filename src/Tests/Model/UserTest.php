<?php

namespace App\Tests\Model;

use App\Dao\DaoAbstract;
use App\Model\User;
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
        $this->assertNotNull($this->model->userEmail);
        $this->assertNotNull($this->model->userPassword);
    }

    public function testFindAll()
    {
        $users = $this->model->findAll(['userEmail' => 'user@example.com']);
        $this->assertCount(1, $users);

        $user = $users[0];

        $this->assertEquals('user@example.com', $user->userEmail);
        $this->assertEquals('Example', $user->userLastName);
        $this->assertEquals(2, $user->userId);
    }

    /**
     * @expectedException \Doctrine\ActiveRecord\Exception\Exception
     */
    public function testGetPasswordException()
    {
        $this->model->userPassword;
    }

    /**
     * @expectedException \App\Exception\InvalidArgumentException
     */
    public function testInsecurePassword()
    {
        $password = 'fooBar';

        $this->model->find(2);

        $this->model->updatePassword($password);
    }

    /**
     * @expectedException \App\Exception\InvalidArgumentException
     */
    public function testEmptyPassword()
    {
        $password = '';

        $this->model->find(2);
        $this->model->updatePassword($password);
    }

    public function testFindByPasswordResetToken()
    {
        $user = $this->model->findByPasswordResetToken('4wai87E67cuDCe9');

        $this->assertEquals(2, $user->getId());
    }

    /**
     * @expectedException \Doctrine\ActiveRecord\Exception\NotFoundException
     */
    public function testFindByPasswordResetTokenWithInvalidToken()
    {
        $this->model->findByPasswordResetToken('XXX');
    }

    public function testFindByVerificationToken()
    {
        $user = $this->model->findByVerificationToken('tkkqEUTj1P13ucm');

        $this->assertEquals(2, $user->getId());
    }

    /**
     * @expectedException \Doctrine\ActiveRecord\Exception\NotFoundException
     */
    public function testFindByVerificationTokenWithInvalidToken()
    {
        $this->model->findByVerificationToken('XXX');
    }

    public function testFindByEmail()
    {
        $user = $this->model->findByEmail('admin@example.com');

        $this->assertEquals(1, $user->getId());
    }

    /**
     * @expectedException \Doctrine\ActiveRecord\Exception\NotFoundException
     */
    public function testFindByEmailError()
    {
        $this->model->findByEmail('admin@XXX.com');
    }

    public function testPasswordIsValid()
    {
        $user = $this->model->find(2);

        $password = 'passwd';

        $result = $user->passwordIsValid($password);

        $this->assertTrue($result);
    }

    public function testVerified()
    {
        $user = $this->model->find(1);
        $this->assertTrue($user->isVerified());
    }

    public function testSetPasswordResetToken()
    {
        DaoAbstract::setDateTimeClassName('\TestTools\Util\FixedDateTime');
        /** @var User $user */
        $user = $this->model->find(1);
        $token = '123456789';
        $user->setPasswordResetToken($token);
        $this->assertInternalType('string', $user->userPasswordResetToken);
        $this->assertGreaterThan(5, strlen($user->userPasswordResetToken));
    }

    /**
     * @expectedException \App\Exception\InvalidArgumentException
     */
    public function testSetPasswordResetTokenError()
    {
        /** @var User $user */
        $user = $this->model->find(1);
        $token = '1234';
        $user->setPasswordResetToken($token);
    }

    public function testDeletePasswordResetToken()
    {
        /** @var User $user */
        $user = $this->model->find(1);
        $user->setPasswordResetToken('123456789');
        $this->assertInternalType('string', $user->userPasswordResetToken);
        $this->assertGreaterThan(5, strlen($user->userPasswordResetToken));
        $user->deletePasswordResetToken();
        $this->assertEmpty($user->userPasswordResetToken);
    }

    public function testVerify()
    {
        /** @var User $user */
        $user = $this->model->find(2);
        $this->assertFalse($user->isVerified());
        $user->verify();
        $this->assertTrue($user->isVerified());
    }
}