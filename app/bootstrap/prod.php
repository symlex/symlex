<?php

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider());

$app->register(new TwigServiceProvider(), array(
    'twig.path'    => array(__DIR__ . '/../../src/View'),
    'twig.options' => array(
        'cache' => __DIR__ . '/../../var/cache/twig',
        'auto_reload' => true
    ),
));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('app', $app);

    return $twig;
}));

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

require __DIR__.'/../config/exceptions.php';

require __DIR__.'/../services.php';

require __DIR__.'/../routing.php';