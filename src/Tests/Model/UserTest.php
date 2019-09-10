<?php

namespace App\Tests\Model;

use App\Dao\DaoAbstract;
use App\Exception\InvalidArgumentException;
use App\Model\User;
use Doctrine\ActiveRecord\Exception\Exception;
use Doctrine\ActiveRecord\Exception\NotFoundException;
use TestTools\TestCase\UnitTestCase;

class UserTest extends UnitTestCase
{
    /**
     * @var \App\Model\User
     */
    protected $model;

    public function setUp(): void
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

    public function testGetPasswordException()
    {
        $this->expectException(Exception::class);
        $this->model->userPassword;
    }

    public function testInsecurePassword()
    {
        $password = 'fooBar';

        $this->model->find(2);
        $this->expectException(InvalidArgumentException::class);

        $this->model->updatePassword($password);
    }

    public function testEmptyPassword()
    {
        $password = '';

        $this->model->find(2);
        $this->expectException(InvalidArgumentException::class);
        $this->model->updatePassword($password);
    }

    public function testFindByPasswordResetToken()
    {
        $user = $this->model->findByPasswordResetToken('4wai87E67cuDCe9');

        $this->assertEquals(2, $user->getId());
    }

    public function testFindByPasswordResetTokenWithInvalidToken()
    {
        $this->expectException(NotFoundException::class);
        $this->model->findByPasswordResetToken('XXX');
    }

    public function testFindByVerificationToken()
    {
        $user = $this->model->findByVerificationToken('tkkqEUTj1P13ucm');

        $this->assertEquals(2, $user->getId());
    }

    public function testFindByVerificationTokenWithInvalidToken()
    {
        $this->expectException(NotFoundException::class);
        $this->model->findByVerificationToken('XXX');
    }

    public function testFindByEmail()
    {
        $user = $this->model->findByEmail('admin@example.com');

        $this->assertEquals(1, $user->getId());
    }

    public function testFindByEmailError()
    {
        $this->expectException(NotFoundException::class);
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
        $this->assertIsString($user->userPasswordResetToken);
        $this->assertGreaterThan(5, strlen($user->userPasswordResetToken));
    }

    public function testSetPasswordResetTokenError()
    {
        /** @var User $user */
        $user = $this->model->find(1);
        $token = '1234';
        $this->expectException(InvalidArgumentException::class);
        $user->setPasswordResetToken($token);
    }

    public function testDeletePasswordResetToken()
    {
        /** @var User $user */
        $user = $this->model->find(1);
        $user->setPasswordResetToken('123456789');
        $this->assertIsString($user->userPasswordResetToken);
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