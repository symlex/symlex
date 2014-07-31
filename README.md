Symlex - Symfony 2 blended with Silex 
=====================================

This ready-to-use boilerplate app is built on Silex, Symfony Components (for dependency injection instead of Pimple)
plus Sympathy Components, which add routing and bootstrapping. Twitter Bootstrap, RequireJS and AngularJS are used for the example front-end code (static home page, login form and simple user management). You can use the back-end with any JavaScript library and REST client or to output static HTML/XML. Symlex also supports command line applications.

**The goal of this project is to simplify Web app development by combining the best available components into a working  system.**

Setup
-----

1. After cloning this repository, you have to run composer to fetch external dependencies:

        composer update

2. As with all Symfony applications, you have to configure your Web server to use the "web" directory as root path (a `.htaccess` file for Apache is included).
 
3. You must import `app/db/schema.sql` into your MySQL database and configure the connection in `app/config/parameters.yml`.

Note: Running "bower", the JavaScript equivalent to composer, is not required to simplify installation (you should consider using it for your own app to keep JS libraries up-to-date).

After successful installation, you can use the email address admin@example.com (or user@example.com) and the password "passwd" to log in.

History
-------
This project startet as a simple Silex boilerplate, since Silex itself doesn't come with a "Standard Edition" that puts you on the right track. I've chosen Silex, since Symfony 2 felt too heavy for many of my projects, I didn't need bundles (http://symfony.com/doc/current/bundles/index.html) and I was looking for a solution to quickly build REST services with convention over configuration.

The only thing I wasn't happy with is Pimple, the dependency injection container that comes with Silex - it feels really shabby for developers coming from Symfony 2. If you're sharing the same experience, you will like this mix of Symfony 2 and Silex, which aims to combine the best of both worlds.

Configuration
-------------
YAML files located in `app/config/` are used to configure the entire system:
- `app/config/web.yml` is used to configure Web (HTTP) applications (bootstrapped in web/app.php)
- `app/config/console.yml` is used to configure command line applications (bootstrapped in app/console)

Bootstrapping
-------------
A custom kernel is used to bootstrap the application. It's just about 150 lines of code, initializes the Symfony dependency injection container and then starts the app:

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

The base kernel class is extended by the application to customize it for the specific purpose (e.g. `src/App/ConsoleApp.php`):

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

Creating a kernel instance and calling run() is enough to start the app (e.g. `app/console`):

```
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\ConsoleApp;
$app = new ConsoleApp (__DIR__);
$app->run();
```

Routing
-------
Matching requests to controller actions is performed on convention instead of configuration. There are three router classes included in the Sympathy library (they configure Silex to perform the actual routing):
- `Sympathy\Silex\Router\RestRouter` for REST requests (JSON)
- `Sympathy\Silex\Router\ErrorRouter` for handling exceptions (detects output format)
- `Sympathy\Silex\Router\TwigRouter` for rendering HTML pages using the Twig template engine

The application's HTTP kernel class must initialize routing and can set optional URL/service name prefixes:
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
- `PUT /api/user/123/item/5` will be routed to `controller.rest.user` service's `putItemAction($id, $itemId,  Request $request)`
