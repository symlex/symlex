Symlex: A Silex Boilerplate with Symfony DI Container
=====================================================

[![Build Status](https://travis-ci.org/lastzero/symlex.png?branch=master)](https://travis-ci.org/lastzero/symlex)

This ready-to-use boilerplate app is built on Silex, Symfony Components (for dependency injection instead of Pimple)
plus Sympathy Components, which add routing and bootstrapping (https://github.com/lastzero/sympathy). Twitter Bootstrap, RequireJS and AngularJS are used for the example front-end code (static home page, login form and user management). You can use the back-end with any JavaScript library/REST client or to output static HTML. An example for command line applications is included as well.

**The goal of this project is to simplify Silex development by providing a working system that favors convention over configuration.**

Setup
-----

1. After cloning this repository, you have to run composer to fetch external dependencies:

        composer update

2. As with all Symfony applications, you have to configure your Web server to use the "web" directory as root path (a `.htaccess` file for Apache is included).
 
3. You must import `app/db/schema.sql` into your MySQL database and configure the connection in `app/config/parameters.yml`.

*Note: Running "bower", the JavaScript equivalent to composer, is not required to simplify installation. Yyou should consider using it for your own app to keep JS libraries up-to-date.*

After successful installation, you can use the email address admin@example.com (or user@example.com) and the password "passwd" to log in.

History
-------
This project started as a simple Silex boilerplate, since Silex itself doesn't come with a "Standard Edition" that puts you on the right track. Using Silex instead of Symfony 2 (with FOSRestBundle) was recommend to me by SensioLabs (the creators of both frameworks) after complaining about serious performance deficiencies - not to mention the unnecessary complexity of certain Symfony bundles or even the bootstrap itself.

The only thing I wasn't happy with is Pimple, the dependency injection container that comes with Silex - it feels really shabby for developers coming from Symfony 2 and makes it hard to reuse existing components developed for Symfony 2. If you're sharing the same experience, you might like this mix of Silex and Symfony, which aims to combine the best of both worlds.

Key Features
------------
- Built on top of well documented standard components
- Contains everything to create full-featured Web applications (Twig template engine, REST routing, dependency injection)
- Clean configuration and bootstrap
- Small code footprint
- High performance

Performance
-----------
It's obvious that PHP framework performance mainly depends on the lines of code that have to be executed for each request. While Symlex was designed to be simple and lean, a good performance certainly is an important by-product of this approach.

Here is a benchmark, comparing the framework overhead for REST requests (Symlex vs Symfony 2 with FOSRestBundle on a Core i7 1.7 GHz running Ubuntu Linux 12.04 / Apache 2 / PHP 5.4.28 with APC enabled):

![PHP frameworks: REST routing overhead](https://lastzero.net/wp-content/uploads/2014/08/overhead_apc.png)

As a rule of thumb, **100 ms** is about the limit for having the user feel that the system is reacting instantaneously, meaning that no special feedback is necessary except to display the result (http://www.nngroup.com/articles/response-times-3-important-limits/). To be more precise, Wikipedia states that the perceptual processor cycle time has a range of 50 to 200 ms for a young adult (http://en.wikipedia.org/wiki/Usability). The total response time also includes network (about 25 ms for DSL), browser and other overhead, which only leaves a small fraction of those 100 ms for implementing the actual business logic.

Bundles
-------
There is no support for bundles in Symlex currently. Using Symfony bundles often adds complexity to the overall architecture: They wrap bootstrap/container configurations (less explicit) and encourage to build bloated applications. Symlex is designed to build focused, lean and fully testable applications: Writing unit tests is often not possible, if certain functionality is exclusively encoded in framework configuration files or annotations (acceptance tests can be created, but they are slow and not suitable for test driven development).

See also: http://stackoverflow.com/questions/19064719/fosuserbundle-what-is-the-point

Configuration
-------------
YAML files located in `app/config/` configure the entire system via dependecy injection:
- `app/config/web.yml` is used to configure Web (HTTP) applications (bootstrapped in web/app.php)
- `app/config/console.yml` is used to configure command-line applications (bootstrapped in app/console)

These files are in the same format you know from Symfony 2. In addition to the regular services, they also contain the actual application as a service ("app"). This provides a uniform approach for bootstrapping Web and command-line applications with the same kernel.

*Note: If debug mode is turned off, the dependency injection container is cached in var/cache/. You have to delete the cache after updating the configuration.*

Bootstrapping
-------------
A light-weight kernel bootstraps the application. It's just about 150 lines of code, initializes the Symfony dependency injection container and then starts the app by calling `run()`:

```
<?php
namespace Sympathy\Bootstrap;

class App
{
    public function getApplication()
    {
        return $this->getContainer()->get('app');
    }
    
    public function run()
    {
        return $this->getApplication()->run();
    }
    
    ...
}
```

The kernel base class can be extended to customize it for a specific purpose (e.g. command line application):

```
<?php
namespace App;
use Sympathy\Bootstrap\App;

class ConsoleApp extends App
{
    public function __construct($appPath, $debug = false)
    {
        parent::__construct('console', $appPath, $debug);
    }

    public function boot()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        parent::boot();
    }
}
```

Creating a kernel instance and calling run() is enough to start the application (see `app/console` and `web/app.php`):

```
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\ConsoleApp;
$app = new ConsoleApp (__DIR__);
$app->run();
```

Routing and Rendering
---------------------
Matching requests to controller actions is performed based on convention instead of extensive configuration. There are three router classes included in the Sympathy library (they configure Silex to perform the actual routing). After routing a request to the appropriate controller action, the router subsequently renders the response to ease controller testing (actions never directly return JSON or HTML):

- `Sympathy\Silex\Router\RestRouter` handles REST requests (JSON)
- `Sympathy\Silex\Router\ErrorRouter` renders exceptions as error messages (HTML or JSON)
- `Sympathy\Silex\Router\TwigRouter` renders regular Web pages via Twig (HTML)

It's easy to create your own custom routing/rendering based on the existing examples.

The application's HTTP kernel class initializes routing and sets optional URL/service name prefixes:
```
<?php
namespace App;
use Sympathy\Bootstrap\App;

class HttpApp extends App
{
    public function __construct($appPath, $debug = false)
    {
        parent::__construct('web', $appPath, $debug);
    }

    public function boot () {
        parent::boot();

        $container = $this->getContainer();
        $container->get('router.error')->route();
        $container->get('router.rest')->route('/api', 'controller.rest.');
        $container->get('router.twig')->route('', 'controller.web.');
    }
}
```

Examples (based on this routing configuration):
- `GET /` will be routed to `controller.web.index` service's `indexAction(Request $request)`
- `POST /session/login` will be routed to `controller.web.session` service's `postLoginAction(Request $request)`
- `GET /api/user` will be routed to `controller.rest.user` service's `cgetAction(Request $request)`
- `GET /api/user/123` will be routed to `controller.rest.user` service's `getAction($id, Request $request)`
- `POST /api/user` will be routed to `controller.rest.user` service's `postAction(Request $request)`
- `PUT /api/user/123/item/5` will be routed to `controller.rest.user` service's `putItemAction($id, $itemId, Request $request)`

Controllers
-----------
Symlex controllers are plain PHP classes. They have to be added as service to `app/config/web.yml`:

```
    controller.rest.user:
        class: App\Rest\UserController
        arguments: [ @model.session, @model.user, @form.user ]
```

*Note: In Symfony 2, controllers aren't services by default. Some Symfony developers give their controllers direct access to the DI container, which makes testing more difficult and breaks the architecture.*

The routers pass on the request instance to each matched controller action as last argument. It contains request parameters and headers: http://symfony.com/doc/current/book/http_fundamentals.html#requests-and-responses-in-symfony

**Web controller actions** can either return nothing (the matching Twig template will be rendered), an array (the Twig template can access the values as variables) or a string (redirect URL). Twig's template base directory can be configured in `app/config/twig.yml` (`twig.path`). The template filename is matching the request route: `[twig.path]/[controller]/[action].twig`. If no controller or action name is given, `index` is the default (the response to `/` is therefore rendered using `index/index.twig`).

Example: https://github.com/lastzero/symlex/blob/master/src/App/Controller/AuthController.php

REST
----
Symlex REST controllers use a naming scheme similar to FOSRestBundle's "implicit resource name definition". The action name is derived from the request method and optional sub resources:

        <?php
        
        class UserController
        {
            ..
        
            public function cgetAction(Request $request)
            {} // [GET] /user
        
            public function postAction(Request $request)
            {} // [POST] /user

            public function getAction($id, Request $request)
            {} // [GET] /user/{id}
            
        
            ..
            public function getCommentsAction($id, Request $request)
            {} // [GET] /user/{id}/comments
        
            ..
        }

**REST controller actions** always return arrays, which are automatically converted to valid JSON. Delete actions can return *null* ("204 No Content").

Example: https://github.com/lastzero/symlex/blob/master/src/App/Rest/UserController.php

Models
------
Symlex isn't designed for any specific database abstraction layer or model library. The boilerplate examples are based on MySQL, Doctrine DBAL and straightforward DAO (data access object)/model classes, that are part of the Sympathy library. They implement the usual CRUD functionality (create, read, update, delete) and separate SQL from model code.

Error Handling
--------------
Exceptions are automatically catched by Silex and then passed on to ErrorRouter, which either renders an HTML error page or returns the error details as JSON (depending on the request headers). Exception class names are mapped to error codes in `app/config/web.yml`:

```
parameters:
    exception.codes:
        InvalidArgumentException: 400
        App\Exception\UnauthorizedException: 401
        App\Exception\AccessDeniedException: 403
        App\Exception\FormInvalidException: 409
        Exception: 500

    exception.messages:
        400: 'Bad request'
        401: 'Unauthorized'
        403: 'Forbidden'
        404: 'Not Found'
        405: 'Method Not Allowed'
        409: 'Conflict'
        500: 'Looks like something went wrong!'

services:
    router.error:
        class: Sympathy\Silex\Router\ErrorRouter
        arguments: [ @app, @twig, %exception.codes%, %exception.messages%, %app.debug% ]
```

The filename for Twig error templates is `src/App/View/error/[code].twig`. If no template is found, the default template (`default.twig`) is used.

Tests
-----
Symlex comes with a pre-configured PHPUnit environment that automatically executes tests found in `src/`:

    [lastzero/symlex]# app/phpunit
    PHPUnit 3.7.37 by Sebastian Bergmann.

    Configuration read from phpunit.xml.dist
    
    ............

    Time: 195 ms, Memory: 6.25Mb
    OK (12 tests, 42 assertions)
