<?php

namespace App\Tests\Model;

use TestTools\TestCase\UnitTestCase;

class UserTest extends UnitTestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = $this->get('model.user');
    }
}