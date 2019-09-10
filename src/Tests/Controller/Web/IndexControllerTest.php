<?php

namespace App\Tests\Controller\Web;

use TestTools\TestCase\UnitTestCase;

class IndexControllerTest extends UnitTestCase
{
    /**
     * @var \App\Controller\Web\IndexController
     */
    protected $controller;

    public function setUp(): void
    {
        $this->controller = $this->get('controller.web.index');
    }

    public function testIndexAction()
    {
        $result = $this->controller->indexAction();

        $this->assertNull($result);
    }
}