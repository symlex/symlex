<?php

namespace App\Tests\Controller;

use TestTools\TestCase\UnitTestCase;

class IndexControllerTest extends UnitTestCase
{
    /**
     * @var \App\Controller\IndexController
     */
    protected $controller;

    public function setUp()
    {
        $this->controller = $this->get('controller.web.index');
    }

    public function testIndexAction()
    {
        $result = $this->controller->indexAction();

        $this->assertNull($result);
    }
}