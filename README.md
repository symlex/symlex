Symlex: A lean framework stack for agile Web development based on Symfony and Vuetify
=====================================================================================

[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/symlex/symlex/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/symlex/symlex.png?branch=master)](https://travis-ci.org/symlex/symlex)
[![Documentation](https://readthedocs.org/projects/symlex-docs/badge/?version=latest&style=flat)](https://docs.symlex.org/en/latest/)
[![GitHub contributors](https://img.shields.io/github/contributors/symlex/symlex.svg)](https://github.com/symlex/symlex/graphs/contributors/)
[![Community Chat](https://img.shields.io/badge/chat-on%20gitter-4aa087.svg)](https://gitter.im/symlex/community)
[![Twitter](https://img.shields.io/badge/follow-@symlexphp-00acee.svg)](https://twitter.com/symlexphp)

**Symlex aims to simplify agile Web development by providing a working system that promotes best practices by example:**

  - Built on top of well documented and tested standard components
  - Contains everything to create full-featured Web applications: Service container, REST routing & Twig template engine
  - Strict use of dependency injection for configuration and bootstrapping
  - Small code and memory footprint
  - Extremely fast compared to other PHP frameworks, especially in combination with [RoadRunner](https://roadrunner.dev/)

Since its initial release in 2014, it has proven to be well suited for rapidly building microservices, 
CLI and single-page applications. It comes complete with working examples from testing to forms and database 
abstraction. Simply delete what you don't need.

The [kernel](https://github.com/symlex/di-microkernel) is tiny and only creates a 
service container for bootstrapping your application within its context.
Using a single container for configuration and dependency injection reduces complexity and leads to improved 
performance compared to other frameworks.
It also prevents developers from thoughtlessly installing bundles without understanding
them. The result is less bloat and simpler, more maintainable and testable code that is fundamental for agile development.

<img align="right" width="622" height="367" src="https://docs.symlex.org/en/latest/img/screenshot.jpg">

Plain classes are used wherever possible to avoid vendor lock-in and enable framework independent code reuse. See [TRADEOFFS.md](TRADEOFFS.md).

You can combine the PHP based backend with any JavaScript library or REST client. The front-end boilerplate is there for 
your convenience and puts you straight on track for building impressive single-page applications with Webpack and Vuetify,
see [demo.symlex.org](https://demo.symlex.org). 
A working example for command line applications is included as well.

Our complete framework documentation can be found on [docs.symlex.org](https://docs.symlex.org/en/latest/).
[Tuzi Liu](https://github.com/tuzimoe) maintains a [Chinese translation](https://docs.symlex.org/zh/latest/) for us.

*Note: https://github.com/symlex/symlex-core contains the kernel and routers as reusable components.*

## Setup ##

Before you start, make sure you have PHP 7.2+, [Composer](https://getcomposer.org/) and [Docker](https://www.docker.com/) installed on your system 
([howto](https://docs.symlex.org/en/latest/osx/) for Mac OS X). 
Instead of using Docker, you can set up your own runtime environment based on the existing 
[Dockerfile](https://github.com/symlex/symlex/tree/master/Dockerfile).
In addition, you will need a [database](https://downloads.mariadb.org/) plus
[nodejs](https://nodejs.org/en/) and [npm](https://www.npmjs.com/) to build the frontend.

**Step 1:** Run `composer` to create a new Symlex project:

```
composer create-project symlex/symlex myapp
```

Composer will ask for config values to generate `app/config/parameters.yml` for you.

Make sure `storage/cache` is writable so that cache files can be created by the app.

**Step 2:** Start [RoadRunner](https://roadrunner.dev/) and [MariaDB](https://mariadb.org/) using `docker-compose`:

```
cd myapp
docker-compose up
```

*Note: This configuration is for testing and development purposes only, see comments in
[docker-compose.yml](https://github.com/symlex/symlex/blob/master/docker-compose.yml) for details.
You might need to tweak it if you run Docker with a different user for security reasons.
On OS X, the current release of Docker is [really slow](https://twitter.com/lastzero/status/829191426391027712) 
in executing PHP from the host's file system.
`docker-compose up -d` runs Docker in the background, but you won't see helpful log messages in this case.*
    
**Step 3:** Let [Make](https://www.gnu.org/software/make/) initialize the database and build the front-end components for you:

```
make terminal
make all database
```

To verify everything is working, run `make test`.

*Note: You can also use this approach to execute other CLI commands later. Make should be pre-installed in 
typical Unix development environments - otherwise you might have to get it first e.g. by installing Xcode 
incl. Command Line Tools on OS X or by adding the `build-base` or `build-essential` package on Linux.
The `Makefile` contains a list of all targets.*

After successful installation, open the site at http://localhost:8081/ and log in as `admin@example.com` using the 
password `passwd`.

YAML files located in `app/config` configure the app based on parameters and services.
The main config files are `app/config/web.yml` and `app/config/console.yml`.

If you add `localhost-debug` to your `/etc/hosts` and access the site with that, it will load in debug
mode (you'll see a stack trace and other debug information on the error pages).

The [mailhog](https://github.com/ian-kent/MailHog) user interface is available at http://localhost:8025/. It can be used
to receive and view mails automatically sent by the system, e.g. when new users are created.

If you want to build a more light-weight app, have a look at our other examples:

 - https://github.com/symlex/rest-api
 - https://github.com/symlex/stream-sampler

Full documentation: https://docs.symlex.org/en/latest/framework/

![Login Screen](https://docs.symlex.org/en/latest/framework/img/login.jpg)

## RoadRunner ##

Symlex now includes [RoadRunner](https://roadrunner.dev/) - a high-performance PHP application server - as an 
alternative to [NGINX](https://en.wikipedia.org/wiki/Nginx). 
It will be automatically downloaded when you build the Docker image.

Our installation instructions for Symlex >= 4.4.0 won't work for previous releases as 
they still use NGINX and PHP-FPM. Instead of `web` and `php`, there is now a single `app` 
service powered by RoadRunner. If you prefer NGINX, you can use an older 
[release](https://github.com/symlex/symlex/releases) or copy the previous config to the new release.
Some of our example apps use NGINX as well.

## About ##

Symlex is maintained by [Michael Mayer](https://blog.liquidbytes.net/about) and
aims to simplify agile Web development by providing a working system that promotes best practices by example.
Michael released his [first PHP framework](http://freshmeat.sourceforge.net/projects/awf) in 2001 and 
has worked with various major framework vendors in the past.
Building this would not have been possible without a lot of prior work by other developers.
Thank you to those and everyone who contributed!

> Choice is the enemy of productivity. Put another way, if your solution does everything, 
> and has no opinions about anything, then it solves nothing. ― *Asim Aslam*

Feel free to send an e-mail to [hello@symlex.org](mailto:hello@symlex.org) if you have any questions, 
need [commercial support](https://blog.liquidbytes.net/contact/) or just want to say hello. 
We welcome contributions of any kind. If you have a bug or an idea, read our 
[guide](CONTRIBUTING.md) before opening an issue.

## Performance ##

It's obvious that PHP framework performance mainly depends on the lines of code that have to be executed for each request. 
While Symlex was designed to be simple and lean, a good performance is a very important by-product of this approach.

> The best code is no code. Where there is no code, there are no bugs. No API to learn. No awkward UI. 
> The best refactors are deletions. ― *Eric Elliott*

As published by [phpbenchmarks.com](http://www.phpbenchmarks.com/en/benchmark/apache-bench/php-7.3/symlex-4.1.html), 
REST requests are more than 40% faster compared to other common PHP frameworks:

<img src="https://symlex.org/images/performance-large.svg" alt="Response times of popular PHP frameworks" width="100%">

Note that these response times were measured in fully optimized production mode on [fast server hardware](http://www.phpbenchmarks.com/en/benchmark-protocol.html) with only 5 concurrent requests. In practice,
differences might be much larger in terms of absolute time. Memory consumption should be considered as well:

<img src="https://symlex.org/images/memory-large.svg" alt="Memory footprint of popular PHP frameworks" width="100%">

**Why should you care?** First, your users will love it. As a rule of thumb, **100 ms** is about the limit for 
having them feel that the system is reacting instantaneously, meaning that no special feedback is necessary except to display the result. The total response time also includes network (~25 ms), browser and other overhead, which only leaves a small fraction of those 100 ms for implementing the actual business logic.
Second, you'll save a lot of money for server infrastructure and developers are more productive as tests are running faster.

## Relationship with Symfony and Silex ##

Symlex was started in 2014 as a simple Silex boilerplate, since Silex itself doesn't come with a "Standard Edition" 
that points you in the right direction. Using Silex instead of Symfony was recommended by SensioLabs (the creators 
of both frameworks) as a light-weight alternative to Symfony + FOSRestBundle for quickly building high-performance 
REST services and single-page Web applications.

It was soon noticed that Pimple - the service container that comes with Silex - feels cumbersome for developers 
coming from Symfony and makes it hard to reuse existing code. In addition, many Silex code examples and even real-world 
applications accessed the service container from all parts of the code (not only the framework itself), 
which circumvents inversion of control and leads to awkward testability. Symlex therefore promotes the strict use of dependency 
injection and combines the convenience of a full-fledged service container with the speed of a micro-framework.

Today, Symlex has its own routing component (based on Symfony 4) and does not use Silex anymore. 
The framework has proven to be useful for a large number of different applications. Some of them were based on the regular
Symfony kernel before and did the change because they were drowning in complexity and suffered from response times well 
above 30 seconds in development mode. Symlex brought them back on track without big changes to their existing code base.

<img src="https://symlex.org/images/symlex-vs-symfony.svg" alt="Micro-Kernel Architecture" width="100%">

## Donations ##

Symlex is a non-profit project run entirely by volunteers. You're most welcome to support us via 
[GitHub Sponsors](https://github.com/sponsors/lastzero), especially if you need help with using our software.
They will match every donation in the first year.

Please leave a star if you like this project, it provides additional motivation to keep going. Thank you very much! <3
