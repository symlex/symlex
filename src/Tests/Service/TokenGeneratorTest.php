<?php

namespace App\Tests\Service;

use App\Service\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    protected string $testToken = '2fd4e1c67a2d28fced849ee1bb76e7391b93eb12';

    public function testGetToken()
    {
        $instance = new TokenGenerator();
        $randomToken1 = $instance->getToken(12);
        $randomToken2 = $instance->getToken(12);

        $this->assertIsString($randomToken1);
        $this->assertIsString($randomToken2);
        $this->assertEquals(24, strlen($randomToken1));
        $this->assertEquals(24, strlen($randomToken2));
        $this->assertNotEquals($randomToken1, $randomToken2);
    }

    public function testGetSmallToken()
    {
        $instance = new TokenGenerator();
        $result = $instance->getSmallToken();

        $this->assertIsString($result);
        $this->assertEquals(16, strlen($result));
    }

    public function testGetMediumToken()
    {
        $instance = new TokenGenerator();
        $result = $instance->getMediumToken();

        $this->assertIsString($result);
        $this->assertEquals(32, strlen($result));
    }

    public function testGetLargeToken()
    {
        $instance = new TokenGenerator();
        $result = $instance->getLargeToken();

        $this->assertIsString($result);
        $this->assertEquals(64, strlen($result));
    }

    public function testGetTokenForTest()
    {
        $instance = new TokenGenerator();
        $instance->setDefaultTokenForTest($this->testToken);

        $randomToken1 = $instance->getToken(12);
        $randomToken2 = $instance->getToken(12);

        $this->assertIsString($randomToken1);
        $this->assertIsString($randomToken2);
        $this->assertEquals(24, strlen($randomToken1));
        $this->assertEquals(24, strlen($randomToken2));
        $this->assertEquals($randomToken1, $randomToken2);

        $instance->setDefaultTokenForTest('42');

        $randomToken3 = $instance->getToken(6);
        $this->assertIsString($randomToken3);
        $this->assertEquals(12, strlen($randomToken3));
        $this->assertEquals('424242424242', $randomToken3);
    }
}