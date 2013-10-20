<?php

// Web Controllers (HTML)
use App\Controller\Web\IndexController;
use App\Controller\Web\ErrorController as WebErrorController;

// REST API Controllers (JSON)
use App\Controller\Api\UserController;
use App\Controller\Api\ErrorController as ApiErrorController;

// Web Controllers (HTML)
$app['error.web.controller'] = $app->share(function () use ($app) {
    return new WebErrorController($app);
});

$app['index.web.controller'] = $app->share(function () use ($app) {
    return new IndexController($app);
});

// REST API Controllers (JSON)
$app['error.api.controller'] = $app->share(function () use ($app) {
    return new ApiErrorController($app);
});

$app['user.api.controller'] = $app->share(function () use ($app) {
    return new UserController($app);
});