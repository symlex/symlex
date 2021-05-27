<?php

namespace App\Service;

use App\Exception\InvalidArgumentException;
use App\Exception\InvalidPasswordException;
use App\Exception\NotFoundException;
use App\Exception\SessionException;
use App\Model\User;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;

class Session
{
    /** @var CacheInterface */
    private $cache;

    /** @var User */
    private $user;

    /** @var Request */
    private $request;

    /** @var string */
    private string $httpHeaderName = 'X-Session-Token';

    /** @var string */
    private string $token = '';

    /** @var string */
    private string $hashAlgorithm = 'sha256';

    private int $oneTimeTokenTTL = 60; // 1 minute

    private int $sessionTokenTTL = 604800; // 7 days

    public function __construct(CacheInterface $cache, User $user)
    {
        $this->cache = $cache;
        $this->user = $user;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        if(!$this->request) {
            throw new InvalidArgumentException('Request not set');
        }

        return $this->request;
    }

    public function login(string $email, string $password)
    : self {
        $results = $this->user->findAll(['userEmail' => $email]);

        if (count($results) === 0) {
            throw new NotFoundException('User not found');
        }

        if (count($results) > 1) {
            throw new SessionException('More than one user for this email address found - please contact support');
        }

        /** @var User $user */
        $user = $results[0];

        if (!$user->passwordIsValid($password)) {
            throw new InvalidPasswordException('Invalid password');
        }

        $this->setUserId($user->getId());
        $this->user = $user;

        return $this;
    }

    public function logout()
    : self {
        $this->cache->set($this->getToken(), '', $this->sessionTokenTTL);
        $this->user = $this->user->createModel();

        return $this;
    }

    public function generateToken(): Session
    {
        $newToken = hash($this->hashAlgorithm, random_bytes(128), false);

        $this->cache->set($newToken, '', $this->sessionTokenTTL);

        $this->setToken($newToken);

        return $this;
    }

    public function getUserId(): int
    {
        $result = $this->cache->get($this->getToken(), '');

        if (empty($result)) {
            throw new SessionException('User ID not set - login required');
        }

        return $result;
    }

    public function setUserId(int $userId): Session
    {
        $this->cache->set($this->getToken(), $userId, $this->sessionTokenTTL);
        return $this;
    }

    public function hasUserId(): bool
    {
        try {
            $result = $this->cache->get($this->getToken(), '') !== '';
        } catch (SessionException $e) {
            $result = false;
        }

        return $result;
    }

    public function getUser()
    {
        if (!$this->user->hasId()) {
            $userId = $this->getUserId();

            $this->user->find($userId);
        }

        return $this->user;
    }

    protected function getHttpHeaderName(): string
    {
        return $this->httpHeaderName;
    }

    public function setToken(string $token)
    : self {
        if (empty($token)) {
            throw new SessionException('Token is empty');
        }

        if (!$this->cache->has($token)) {
            throw new SessionException('Invalid session token');
        }

        $this->token = $token;

        return $this;
    }

    public function invalidate()
    : self {
        $this->cache->delete($this->getToken());
        $this->token = '';
        $this->user = $this->user->createModel();

        return $this;
    }

    public function hasToken(): bool
    {
        try {
            $this->getToken();
            return true;
        } catch (SessionException $e) {
            return false;
        }
    }

    public function getToken(): string
    {
        if ($this->token == '') {
            $request = $this->getRequest();

            $isGetRequest = ($request->getMethod() == 'GET');

            if ($isGetRequest && ($oneTimeToken = $request->query->get('t')) && $this->cache->has($oneTimeToken)) {
                // Use one time token, if exists (for GET requests only)
                $token = $this->cache->get($oneTimeToken);
                $this->cache->delete($oneTimeToken);
            } else {
                // Get session token from HTTP header
                $token = $this->getRequest()->headers->get($this->getHttpHeaderName(), '');
            }

            if (empty($token)) {
                throw new SessionException('Session token not set - ' . $this->getHttpHeaderName() . '  header missing?');
            }

            $this->setToken($token);
        }

        return $this->token;
    }

    public function getUserFirstName(): string
    {
        $result = $this->isUser() ? $this->getUser()->userFirstName : '';

        return $result;
    }

    public function getUserLastName(): string
    {
        $result = $this->isUser() ? $this->getUser()->userLastName : '';

        return $result;
    }

    public function isAnonymous(): bool
    {
        return !$this->hasUserId();
    }

    public function isUser(): bool
    {
        return $this->hasUserId();
    }

    public function isAdmin(): bool
    {
        return $this->isUser() ? $this->getUser()->isAdmin() : false;
    }

    public function createOneTimeToken(): string
    {
        $oneTimeToken = hash($this->hashAlgorithm, random_bytes(128), false);

        $this->cache->set($oneTimeToken, $this->getToken(), $this->oneTimeTokenTTL);

        return $oneTimeToken;
    }
}