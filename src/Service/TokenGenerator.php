<?php

namespace App\Service;

use App\Exception\InvalidArgumentException;

class TokenGenerator
{
    private string $defaultTokenForTest = '';

    public function setDefaultTokenForTest(string $token)
    {
        $this->defaultTokenForTest = $token;
    }

    public function getSmallToken()
    {
        return $this->getToken(8);
    }

    public function getMediumToken()
    {
        return $this->getToken(16);
    }

    public function getLargeToken()
    {
        return $this->getToken(32);
    }

    protected function hasDefaultTokenForTest()
    : bool {
        return $this->defaultTokenForTest != '';
    }

    public function getToken(int $bytes = 16)
    : string {
        if ($bytes < 1) {
            throw new InvalidArgumentException('Token must at least contain one byte');
        }

        if ($this->hasDefaultTokenForTest()) {
            $stringLength = $bytes * 2; // Bytes converted to hex
            $result = substr($this->defaultTokenForTest, 0, $stringLength);
            $result = str_pad($result, $stringLength, $this->defaultTokenForTest);
        } else {
            $result = bin2hex(random_bytes($bytes));
        }

        return $result;
    }
}