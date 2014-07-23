<?php

namespace App\Tests\Model;

use TestTools\TestCase\UnitTestCase;

class SessionTest extends UnitTestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = $this->get('model.session');
    }
}