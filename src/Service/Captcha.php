<?php

namespace App\Service;

use App\Exception\LogicException;
use Psr\SimpleCache\CacheInterface;
use Gregwar\Captcha\CaptchaBuilder;

class Captcha
{
    /** @var CacheInterface */
    private $cache;

    /** @var CaptchaBuilder */
    private $captchaBuilder;

    /** @var TokenGenerator */
    private $tokenGenerator;

    private string $token = '';

    private int $tokenTTL = 1200; // 20 minutes

    public function __construct(CacheInterface $cache, CaptchaBuilder $captchaBuilder, TokenGenerator $tokenGenerator)
    {
        $this->cache = $cache;
        $this->captchaBuilder = $captchaBuilder;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function build()
    : self {
        $this->captchaBuilder->build();
        $this->token = $this->tokenGenerator->getMediumToken();
        $this->cache->set($this->token, $this->captchaBuilder->getPhrase(), $this->tokenTTL);

        return $this;
    }

    public function getPhrase(): string
    {
        return $this->cache->get($this->getToken());
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        if (empty($this->token)) {
            throw new LogicException('Token not set - you need to call build() first');
        }

        return $this->token;
    }

    public function deleteToken(string $token)
    {
        $this->cache->delete($token);
        $this->token = '';
    }

    public function getInline(): string
    {
        return $this->captchaBuilder->inline();
    }

    public function getImage()
    {
        return $this->captchaBuilder->get();
    }

    public function isValid(string $token, string $phrase): bool
    {
        if(empty($token) || empty($phrase)) {
            return false;
        }

        $expected = $this->cache->get($token);

        return $phrase === $expected;
    }
}