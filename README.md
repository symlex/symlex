Symlex - Symfony 2 blended with Silex 
=====================================

This ready-to-use boilerplate app is built on Silex, Symfony Components (for dependency injection instead of Pimple)
plus Sympathy Components, which add routing and bootstrapping. Twitter Bootstrap, RequireJS and AngularJS are used for the example front-end code (static home page, login form and simple user management).

**The goal of this project is to simplify Web app development by combining the best available components into a working  system.**

Setup
-----

1. After cloning this repository, you have to run composer to fetch external dependencies:

        composer update

2. As with all Symfony applications, you have to configure your Web server to use the "web" directory as root path (a `.htaccess` file for Apache is included).
 
3. You must import `app/db/schema.sql` into your MySQL database and configure the connection in `app/config/parameters.yml`.

Note: Running "bower", the JavaScript equivalent to composer, is not required to simplify installation (you should consider using it for your own app to keep JS libraries up-to-date).

After successful installation, you can use the email address "admin@example.com" (or user@example.com) and the password "passwd" to log in.
