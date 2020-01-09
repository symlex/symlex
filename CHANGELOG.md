Changelog
=========

Release 4
---------

* 4.4.2 Updated frontend dependencies and fixed webpack source maps

* 4.4.1 Upgrade to RoadRunner 1.5.2, Symfony 4.4.1 and PHP 7.4

* 4.4.0 Removed nginx and refactored example configuration to be cloud-ready (use env variables)

* 4.3.0 RoadRunner PHP application server included as an alternative to nginx; improved UI

* 4.2.12 Upgraded frontend dependencies

* 4.2.11 Frontend code clean-up

* 4.2.10 Upgraded frontend dependencies and project structure

* 4.2.9 Upgraded to Symlex Core 4.2

* 4.2.8 Improved install instructions

* 4.2.7 Documentation clean-up

* 4.2.6 Improved change password form, navigation, and support for small screens (full responsive)

* 4.2.5 Enabled caching for Symfony\Component\Translation\Translator (improved performance)

* 4.2.4 Changed icons in main navigation; removed Font Awesome from frontend and error pages (smaller builds)

* 4.2.3 Improved frontend tests and docker-compose.yml; code clean-up

* 4.2.2 Upgraded Dockerfile to PHP 7.3; upgraded and improved frontend; tested with Symfony 4.2.1

* 4.2.1 Changed theme colors to blue-grey

* 4.2.0 Migrated frontend from VueMaterial to Vuetify

* 4.1.3 Increased version numbers of dependencies in composer.json; improved documentation and welcome template

* 4.1.2 Fixed error handler config (namespace changed); improved migration notes

* 4.1.1 Improved documentation and tested with symlex/di-microkernel v2.0.2

* 4.1.0 Upgraded to symlex-core 4.0 and removed all references to Silex
    - Router callback parameter order changed slightly (Request is always first)
    - Symlex routers moved to the `Symlex\Router\Web` namespace
    - Symlex exceptions moved to the `Symlex\Exception` namespace
    - Web app is `Symlex\Application\Web` now instead of `Silex\Application` (see `app/config/web.yml`)

* 4.0.1, 4.0.2 & 4.0.3 Improved documentation & code clean-up

* 4.0.0 New release of Symlex based on Symfony 4.1 and Vue.js

Release 3
---------

* 3.0.6 Fixed links in home page partial

* 3.0.5 Service config file refactoring (code clean-up)

* 3.0.4 Updated config file names in documentation

* 3.0.3 Improved support for minified CSS & JS

* 3.0.2 Refactored service container configuration

* 3.0.1 Refactored users controller & user forms

* 3.0.0 Upgraded to symlex-core 3.2; improved user management, commands, documentation, routing & type hints

Release 2
---------

* 2.4.2 Improved user model and documentation

* 2.4.1 Updated docker command in readme

* 2.4.0 Moved from mysql to mariadb and improved docker config

* 2.3.0 Repository moved to symlex/symlex

* 2.2.1 Added support for mailhog (UI for testing mail delivery)

* 2.2.0 Upgraded PHP InputValidation and Doctrine ActiveRecord to 4.0

* 2.1.4 Updated to php-input-validation 3.0.1

* 2.1.3 Fixed coverage path in build.xml

* 2.1.2 Fixed clearcache script

* 2.1.1 Renamed var to storage (like Laravel does it)

* 2.1.0 Upgraded to php-input-validation 3.0 and improved documentation

* 2.0.4 Improved error pages

* 2.0.1, 2.0.2 & 2.0.3 Improved documentation

* 2.0.0 Upgraded to Silex 2; refactored frontend code; improved documentation and Docker support

Release 1
---------

* 1.1.1 Added security checker

* 1.1.0 Added Docker config and refactored for PHP 7, PHPUnit 6 and PSR-4 compatibility

* 1.0.3 Replaced symfony console dialoghelper with questionhelper

* 1.0.2 Upgraded dependencies

* 1.0.1 Improved documentation and upgraded dependencies

* 1.0.0 Tested for PHP 7 compatibility

Pre-release
-----------

* 0.9 Support for Doctrine DBAL 2.5

* 0.8 Added unit tests and improved project structure

* 0.7 Added support for doctrine migrations

* 0.6 Improved documentation, home template and fixed router exceptions

* 0.5 Moved core components to lastzero/symlex-core

* 0.4 Improved user model and documentation

* 0.3 Improved documentation and default config

* 0.2 Improved documentation

* 0.1 Initial pre-release