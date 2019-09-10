<?php

namespace App\Tests\Service;

use App\Service\Captcha;
use Psr\SimpleCache\CacheInterface;
use TestTools\TestCase\UnitTestCase;

class CaptchaTest extends UnitTestCase
{
    /** @var Captcha */
    protected $captcha;

    /** @var CacheInterface */
    protected $cache;

    public function setUp(): void
    {
        $container = $this->getContainer();
        $this->cache = $container->get('cache');
        $this->captcha = $container->get('service.captcha');
    }

    public function testBuild()
    {
        $this->captcha->build();

        $token = $this->captcha->getToken();

        $this->assertRegExp('/[a-zA-Z0-9]{16}/', $token);

        $phrase = $this->captcha->getPhrase();

        $this->assertIsString($phrase);
        $this->assertGreaterThanOrEqual(2, strlen($phrase));

        $valid = $this->captcha->isValid($token, $phrase);

        $this->assertTrue($valid);

        $invalid = $this->captcha->isValid($token, 'foo');

        $this->assertFalse($invalid);
    }
}
