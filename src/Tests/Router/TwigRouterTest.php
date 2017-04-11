<?php

namespace App\Tests\Router;

use App\Service\Session;
use Silex\Application;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use TestTools\TestCase\UnitTestCase;
use App\Router\TwigRouter;

class TwigRouterTest extends UnitTestCase
{
    /** @var TwigRouter */
    protected $router;

    /** @var Application */
    protected $app;

    /** @var FakeWebController */
    protected $controller;

    /** @var Container */
    protected $container;

    /** @var Session */
    protected $session;

    public function setUp()
    {
        $this->container = $this->getContainer();
        $this->app = $this->container->get('app.silex');
        $this->router = $this->container->get('router.twig');
        $this->controller = $this->container->get('controller.web.fake');
        $this->session = $this->container->get('service.session');
        $this->container->get('router.error')->route();
    }

    public function testIndexRoute()
    {
        $request = Request::create('http://localhost/fake/index');
        $this->router->route('/', 'controller.web.');
        $response = $this->app->handle($request);
        $this->assertEquals('indexAction', $response->getContent());
        $this->assertEquals('indexAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
    }

    public function testPostIndexRoute()
    {
        $request = Request::create('http://localhost/fake/index', 'POST');
        $csrfToken = $this->session->initCsrfToken()->getCsrfToken();
        $request->headers->add(array('X-CSRF-Token' => $csrfToken));
        $this->router->route('/', 'controller.web.');
        $response = $this->app->handle($request);
        $this->assertEquals('postIndexAction', $response->getContent());
        $this->assertEquals('postIndexAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
    }

    public function testFooRoute()
    {
        $request = Request::create('http://localhost/fake/foo/345', 'GET');
        $this->router->route('/', 'controller.web.');
        $response = $this->app->handle($request);
        $this->assertEquals('fooAction', $response->getContent());
        $this->assertEquals('fooAction', $this->controller->actionName);
        $this->assertInstanceOf(Request::class, $this->controller->request);
    }
}