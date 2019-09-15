<?php

/**
 * Roadrunner worker inspired by https://roadrunner.dev/docs/integrations-symfony
 *
 * @author Michael Mayer <michael@liquidbytes.net>
 * @license MIT
 */

ini_set('display_errors', 'stderr');

use App\Kernel\WebApp;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\PSR7Client;
use Spiral\RoadRunner\Worker;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\StreamFactory;
use Zend\Diactoros\UploadedFileFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// Set to true to enable debug mode (more detailed errors incl stack trace)
$debugMode = false;

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}

// Create Symlex kernel instance
$app = new WebApp (__DIR__, $debugMode);

// HTTP helper classes
$relay = new StreamRelay(STDIN, STDOUT);
$psr7 = new PSR7Client(new Worker($relay));
$httpFoundationFactory = new HttpFoundationFactory();
$psrHttpFactory = new PsrHttpFactory(
    new ServerRequestFactory,
    new StreamFactory,
    new UploadedFileFactory,
    new ResponseFactory
);

// Handle requests
while ($req = $psr7->acceptRequest()) {
    try {
        $request = $httpFoundationFactory->createRequest($req);
        $response = $app->handle($request);
        $psr7->respond($psrHttpFactory->createResponse($response));
        $app->reboot();
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}