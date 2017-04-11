Symlex: Silex + Symfony
=======================

[![Build Status](https://travis-ci.org/symlex/symlex.png?branch=master)](https://travis-ci.org/symlex/symlex)
[![Latest Stable Version](https://poser.pugx.org/symlex/symlex/v/stable.svg)](https://packagist.org/packages/symlex/symlex)
[![License](https://poser.pugx.org/symlex/symlex/license.svg)](https://packagist.org/packages/symlex/symlex)

Symlex is a complete high-performance PHP framework based on **Silex 2**. Instead of Pimple, it uses 
the well known Symfony [service container](http://symfony.com/doc/current/service_container.html). 
It promotes the strict use of dependency injection for implementing 
[inversion of control](https://martinfowler.com/articles/injection.html) and improved testability.
Since its first release in 2014, it has proven to be well suited for building microservices, CLI and single-page applications.

You can use Symlex with any JavaScript library and REST client or to output static HTML. 
The front-end example is based on AngularJS 1.6, Bootstrap, RequireJS and Bower for package management.
A working [example](https://github.com/symlex/symlex/blob/master/src/Command/PasswordResetCommand.php) for command 
line applications is included as well.

**The goal of this project is to simplify Silex development by providing a working system that favors convention 
over configuration.**

*Note: https://github.com/symlex/symlex-core contains the bootstrap and routers as reusable components.*

Setup
-----

Before you start, make sure you got PHP 7, Composer and Docker installed on your system (short [howto](OSX_HOWTO.md) 
for Mac OS X users). Instead of using Docker, you can also setup your own runtime environment based on the existing 
Docker configuration.

**Step 1:** Run [Composer](https://getcomposer.org/) to create a new Symlex project:

```
composer create-project symlex/symlex symlex
```

**Step 2:** Start nginx, PHP and MySQL using [Docker](https://www.docker.com/):

```
cd symlex
docker-compose up
```

*Note: This docker-compose configuration is for testing and development purposes only. On OS X, the current release of 
Docker is [really slow](https://twitter.com/lastzero/status/829191426391027712) in executing PHP from the host's file system.*

**Step 3:** Let [Phing](https://www.phing.info/) initialize the database and build the front-end components for you:

```
docker-compose exec php bash
bin/phing build
```

*Note: You can also use this approach to execute other CLI commands later. Alternatively, you can install npm, bower
and requirejs locally and link "db" to 127.0.0.1 in /etc/hosts to run commands directly on your host.*

After successful installation, open the site at http://localhost:8081/ and log in as `admin@example.com` using the 
password `passwd`.

The [mailhog](https://github.com/ian-kent/MailHog) user interface is available at http://localhost:8082/. It can be used
to receive and view mails automatically sent by the system, e.g. when new users are created.

History
-------
This project started in 2014 as a simple Silex boilerplate, since Silex itself doesn't come with a "Standard Edition" 
that points you in the right direction. Using Silex instead of Symfony was recommend to me by a friend working at SensioLabs 
(the creators of both frameworks) as a light-weight alternative to Symfony + FOSRestBundle for quickly building 
high-performance REST services and single-page Web applications.

The only thing I wasn't happy with is Pimple, the service container that comes with Silex - it feels 
cumbersome for developers coming from Symfony and makes it hard to reuse existing code. In addition, most Silex examples 
and applications I found access the service container from all parts of the code (not only the framework itself), 
which is the opposite of inversion of control and leads to awkward testability. Symlex therefore promotes
the strict use of dependency injection and combines the convenience of the Symfony service container 
with the speed of Silex.

Today, the framework is in use for a number of applications I worked on for my [clients](https://lastzero.net/about/).
Some of them had Symfony before and did the change because they were drowning in complexity and suffered from 
response times well above 200ms. Symlex brought them back on track without big changes to their existing code base.

Key Features
------------
- Built on top of well documented standard components
- Contains everything to create full-featured Web applications: Symfony service container, REST routing & Twig template engine
- Strict use of dependency injection for configuration and bootstrapping
- Small code footprint
- High performance

Performance
-----------
It's obvious that PHP framework performance mainly depends on the lines of code that have to be executed for each request. While Symlex was designed to be simple and lean, a good performance certainly is an important by-product of this approach.

"The best code is no code. Where there is no code, there are no bugs. No API to learn. No awkward UI. The best refactors are deletions." -- [Eric Elliott](https://twitter.com/_ericelliott/status/671970774958272512)

Here is a benchmark, comparing the response time of Symlex and Symfony REST Edition for a GET request that returns a row from the database (Ubuntu 16.04 LTS with PHP 7.1 FPM, MySQL 5.7 and nginx; all optimizations on):

![PHP frameworks: REST routing overhead](https://lastzero.net/wp-content/uploads/2017/02/symlex_vs_symfony_rest_edition.png)

**Why should you care?** As a rule of thumb, **100 ms** is about the limit for having the user feel that the system is reacting instantaneously, meaning that no special feedback is necessary except to display the result (http://www.nngroup.com/articles/response-times-3-important-limits/). To be more precise, Wikipedia states that the perceptual processor cycle time has a range of 50 to 200 ms for a young adult (http://en.wikipedia.org/wiki/Usability). The total response time also includes network (about 25 ms for DSL), browser and other overhead, which only leaves a small fraction of those 100 ms for implementing the actual business logic.

Configuration
-------------
YAML files located in `app/config/` configure the entire system via dependecy injection. The filename matches the application's environment name:
- `app/config/web.yml` configures Web (HTTP) applications bootstrapped in `web/app.php`
- `app/config/console.yml` configures command-line applications bootstrapped in `app/console`

These files are in the same format you know from Symfony. In addition to the regular services, they also contain the actual application as a service ("app"):

    services:
        app:
            class: Silex\Application

This provides a uniform approach for bootstrapping Web (`Silex\Application`) and command-line (`Symfony\Component\Console\Application`) applications with the same kernel.

*Note: If debug mode is turned off, the service container is cached in storage/cache/. You have to run `app/clearcache` after updating the configuration. To disable caching completely, add `container.cache: false` to  `app/config/parameters.yml`*

Bootstrapping
-------------
A light-weight kernel bootstraps the application. It's just about 150 lines of code, initializes the Symfony service container and then starts the app by calling `run()`:

```php
<?php

namespace DIMicroKernel;

class Kernel
{
    protected $environment;
    protected $debug;
    protected $appPath;

    public function __construct($environment = 'app', $appPath = '', $debug = false)
    {
        $this->environment = $environment;
        $this->debug = $debug;
        $this->appPath = $appPath;

        $this->boot();
    }
    
    ...
    
    public function getApplication()
    {
        return $this->getContainer()->get('app');
    }
    
    public function run()
    {
        return $this->getApplication()->run();
    }
}
```

The kernel base class can be extended to customize it for a specific purpose (e.g. command line application):

```php
<?php
namespace App\Kernel;

use DIMicroKernel\Kernel;

class ConsoleApp extends Kernel
{
    public function __construct($appPath, $debug = false)
    {
        parent::__construct('console', $appPath, $debug);
    }

    public function setUp()
    {
        chdir($this->getAppPath());
        set_time_limit(0);
        ini_set('memory_limit', '-1');
    }
}
```

Creating a kernel instance and calling run() is enough to start the application (see `app/console` and `web/app.php`):

```php
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Kernel\ConsoleApp;
$app = new ConsoleApp (__DIR__);
$app->run();
```

Routing and Rendering
---------------------
Matching requests to controller actions is performed based on convention instead of extensive configuration. There are three router classes included in the core library (they configure Silex to perform the actual routing). After routing a request to the appropriate controller action, the router subsequently renders the response to ease controller testing (actions never directly return JSON or HTML):

- `Symlex\Router\RestRouter` handles REST requests (JSON)
- `Symlex\Router\ErrorRouter` renders exceptions as error messages (HTML or JSON)
- `Symlex\Router\TwigRouter` renders regular Web pages via Twig (HTML)

It's easy to create your own custom routing/rendering based on the existing examples.

The application's HTTP kernel class initializes routing and sets optional URL/service name prefixes:
```php
<?php

namespace App\Kernel;

use DIMicroKernel\Kernel;

class WebApp extends Kernel
{
    public function __construct($appPath, $debug = false)
    {
        parent::__construct('web', $appPath, $debug);
    }

    public function init()
    {
        if ($this->debug) {
            ini_set('display_errors', 1);
        }
    }
    
    protected function setUp()
    {
        $container = $this->getContainer();

        $container->get('router.error')->route();
        $container->get('router.rest')->route('/api', 'controller.rest.');
        $container->get('router.twig')->route('', 'controller.web.');
    }
}
```

Routing examples based on the default configuration in `App\Kernel\WebApp`:
- `GET /` will be routed to `controller.web.index` service's `indexAction(Request $request)`
- `POST /session/login` will be routed to `controller.web.session` service's `postLoginAction(Request $request)`
- `GET /api/users` will be routed to `controller.rest.users` service's `cgetAction(Request $request)`
- `POST /api/users` will be routed to `controller.rest.users` service's `postAction(Request $request)`
- `OPTIONS /api/users` will be routed to `controller.rest.users` service's `coptionsAction(Request $request)`
- `GET /api/users/123` will be routed to `controller.rest.users` service's `getAction($id, Request $request)`
- `OPTIONS /api/users/123` will be routed to `controller.rest.users` service's `optionsAction($id, Request $request)`
- `GET /api/users/123/comments` will be routed to `controller.rest.users` service's `cgetCommentsAction($id, Request $request)`
- `GET /api/users/123/comments/5` will be routed to `controller.rest.users` service's `getCommentsAction($id, $commendId, Request $request)`
- `PUT /api/users/123/comments/5` will be routed to `controller.rest.users` service's `putCommentsAction($id, $commendId, Request $request)`

Controllers
-----------
Symlex controllers are plain PHP classes. They have to be added as service to `app/config/web.yml`:

```yaml
    controller.rest.users:
        class: App\Rest\UsersController
        arguments: [ @model.session, @model.user, @form.user ]
```

*Note: In Symfony, controllers aren't services by default. Some Symfony developers give their controllers direct access to the DI container, which makes testing more difficult and breaks the architecture.*

The routers pass on the request instance to each matched controller action as last argument. It contains request parameters and headers: http://symfony.com/doc/current/book/http_fundamentals.html#requests-and-responses-in-symfony

**Web controller actions** can either return nothing (the matching Twig template will be rendered), an array (the Twig template can access the values as variables) or a string (redirect URL). Twig's template base directory can be configured in `app/config/twig.yml` (`twig.path`). The template filename is matching the request route: `[twig.path]/[controller]/[action].twig`. If no controller or action name is given, `index` is the default (the response to `/` is therefore rendered using `index/index.twig`).

Example: https://github.com/lastzero/symlex/blob/master/src/Controller/AuthController.php

REST
----
Symlex REST controllers use a naming scheme similar to FOSRestBundle's "implicit resource name definition". The action name is derived from the request method and optional sub resources:

```php
<?php

class UsersController
{
    ..

    public function cgetAction(Request $request)
    {} // [GET] /users

    public function coptionsAction(Request $request)
    {} // [OPTIONS] /users
    
    public function postAction(Request $request)
    {} // [POST] /users

    public function getAction($id, Request $request)
    {} // [GET] /users/{id}
    
    public function optionsAction($id, Request $request)
    {} // [OPTIONS] /users/{id}

    ..
    public function cgetCommentsAction($id, Request $request)
    {} // [GET] /users/{id}/comments
    
    public function getCommentsAction($id, $commentId, Request $request)
    {} // [GET] /users/{id}/comments/{commentId}

    ..
}
```

**REST controller actions** always return arrays, which are automatically converted to valid JSON. Delete actions can return *null* ("204 No Content").

Example: https://github.com/lastzero/symlex/blob/master/src/Rest/UserController.php

Command-line Interface
----------------------
Running `app/console` lists all commands available. The following commands including Doctrine Migrations 
for creating and migrating database tables are supported out of the box:

Command                  | Description
-------------------------|----------------------------------------------------------------------------
migrations:execute       | Execute a single migration version up or down manually
migrations:generate      | Generate a blank migration class
migrations:migrate       | Execute a migration to a specified version or the latest available version
migrations:status        | View the status of a set of migrations
migrations:version       | Manually add and delete migration versions from the version table
database:create          | Creates the database configured in app/config/parameters.yml
database:drop            | Drops the database configured in app/config/parameters.yml
database:insert-fixtures | Inserts database fixtures for testing (see app/db/fixtures/)
user:create              | Creates a new user
user:reset-password      | Sends a link to a user's email address for password reset

Models, Forms & Databases
-------------------------
Symlex isn't designed for any specific database abstraction layer or model library. The examples are based on MySQL and [Doctrine ActiveRecord](https://github.com/symlex/doctrine-active-record). It is a lot less complex, faster, and has less overhead than for example Datamapper ORM implementations.

The [InputValidation](https://github.com/symlex/input-validation) package provides secure whitelist validation for validating user input data in the controller layer before passing it to models.

The following example shows how to work with those libraries in a REST controller context. Note, how easy it is to avoid deeply nested structures. User model and form are injected as dependencies.

```php
namespace App\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use App\Exception\FormInvalidException;
use App\Form\UserForm;
use App\Model\UserModel;

class UserController
{
    protected $user;
    protected $form;

    public function __construct(UserModel $user, UserForm $form)
    {
        $this->user = $user;
        $this->form = $form;
    }

    public function getAction($id)
    {
        return $this->user->find($id)->getValues();
    }

    public function deleteAction($id)
    {
        return $this->user->find($id)->delete();
    }

    public function putAction($id, Request $request)
    {
        $this->user->find($id);
        $this->form->setDefinedWritableValues($request->request->all())->validate();

        if($this->form->hasErrors()) {
            throw new FormInvalidException($this->form->getFirstError());
        } 
        
        $this->user->update($this->form->getValues());

        return $this->user->getValues();
    }

    public function postAction(Request $request)
    {
        $this->form->setDefinedWritableValues($request->request->all())->validate();

        if($this->form->hasErrors()) {
            throw new FormInvalidException($this->form->getFirstError());
        }
        
        $this->user->save($this->form->getValues());

        return $this->user->getValues();
    }
}
```

Error Handling
--------------
Exceptions are automatically catched by Silex and then passed on to ErrorRouter, which either renders an HTML error page or returns the error details as JSON (depending on the request headers). Exception class names are mapped to error codes in `app/config/web.yml`:

```yaml
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
        class: Symlex\Router\ErrorRouter
        arguments: [ @app, @twig, %exception.codes%, %exception.messages%, %app.debug% ]
```

The filename for Twig error templates is `src/App/View/error/[code].twig`. If no template is found, the default template (`default.twig`) is used.

Bundles
-------
There is no support for bundles in Symlex currently. Using Symfony bundles often adds complexity to the overall architecture: They hide bootstrap/configuration details and encourage to build bloated applications. Symlex is designed to build focused, lean and fully testable applications: Writing meaningful component tests is not possible, if certain functionality is exclusively encoded in framework configuration files or magically generated by bundles (acceptance tests can be created, but they are slow and not suitable for test driven development or refactoring tasks).

See also: http://stackoverflow.com/questions/19064719/fosuserbundle-what-is-the-point

Tests
-----
Symlex comes with a pre-configured PHPUnit environment that automatically executes tests found in `src/`:

    [lastzero/symlex]# app/phpunit
    PHPUnit 4.8.18 by Sebastian Bergmann and contributors.

    .....................

    Time: 147 ms, Memory: 11.25Mb
    OK (21 tests, 53 assertions)
    
See also [TestTools - Adds a service container and self-initializing fakes to PHPUnit](https://github.com/lastzero/test-tools)
