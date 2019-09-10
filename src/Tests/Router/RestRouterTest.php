<?php

namespace App\Tests\Router;

use App\Service\Session;
use Symlex\Application\Web;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use TestTools\TestCase\UnitTestCase;
use App\Router\RestRouter;

class RestRouterTest extends UnitTestCase
{
    /** @var RestRouter */
    protected $router;

    /** @var Web */
    protected $app;

    /** @var FakeRestController */
    protected $controller;

    /** @var Container */
    protected $container;

    /** @var Session */
    protected $session;

    public function setUp(): void
    {
        $this->container = $this->getContainer();
        $this->app = $this->container->get('app.web');
        $this->router = $this->container->get('router.rest');
        $this->controller = $this->container->get('controller.rest.fake');
        $this->session = $this->container->get('service.session');
        $this->container->get('router.error')->route();
    }

    public function testCgetRoute()
    {
        $request = Request::create('http://localhost/api/fake');
        $this->router->route('/api', 'controller.rest.');
        $response = $this->app->handle($request);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals('cgetAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('request', $result);
        $this->assertArrayHasKey('actionName', $result);
        $this->assertEquals('cgetAction', $result['actionName']);
        $this->assertIsArray($result['request']);
    }

    public function testGetRoute()
    {
        $request = Request::create('http://localhost/api/fake/345');
        $this->router->route('/api', 'controller.rest.');
        $response = $this->app->handle($request);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals('getAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('request', $result);
        $this->assertArrayHasKey('actionName', $result);
        $this->assertEquals('getAction', $result['actionName']);
        $this->assertEquals(345, $result['id']);
        $this->assertIsArray($result['request']);
    }

    public function testOptionsCommentRoute()
    {
        $request = Request::create('http://localhost/api/fake/345/comment/1', 'OPTIONS');
//        $csrfToken = $this->session->initCsrfToken()->getCsrfToken();
//        $request->headers->add(array('X-CSRF-Token' => $csrfToken));
        $this->router->route('/api', 'controller.rest.');
        $response = $this->app->handle($request);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals('optionsCommentAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('request', $result);
        $this->assertArrayHasKey('actionName', $result);
        $this->assertEquals('optionsCommentAction', $result['actionName']);
        $this->assertEquals(345, $result['id']);
        $this->assertEquals(1, $result['commentId']);
        $this->assertIsArray($result['request']);
    }
}