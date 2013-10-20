<?php

use Symfony\Component\HttpFoundation\Request;
use Exception\NotFoundException;

$webRequestHandler =  function ($controller, Request $request, $action = '') use ($app) {
    if(!$action) {
        $action = 'index';
    }

    $prefix = strtolower($request->getMethod());
    $parts = explode('/', $action);

    $subResources = '';
    $params = array();

    $count = count($parts);

    for ($i = 0; $i < $count; $i++) {
        $subResources .= ucfirst($parts[$i]);

        if (isset($parts[$i + 1])) {
            $i++;
            $params[] = $parts[$i];
        }
    }

    $params[] = $request;
    $actionName = $prefix . $subResources . 'Action';

    $controllerService = strtolower($controller) . '.web.controller';

    if(!isset($app[$controllerService])) {
        throw new NotFoundException ('Web controller service not found: ' . $controllerService);
    }

    $controllerInstance = $app[$controllerService];

    if($prefix == 'get' && !method_exists ($controllerInstance , $actionName)) {
        $actionName = $subResources . 'Action';
    }

    if(!method_exists($controllerInstance, $actionName)) {
        throw new NotFoundException ('Web controller method not found: ' . $actionName);
    }

    $result = call_user_func_array(array($controllerInstance, $actionName), $params);

    return $result;
};

$app->get('/', 'index.web.controller:indexAction');
$app->match('/{controller}', $webRequestHandler);
$app->match('/{controller}/{action}', $webRequestHandler)->assert('action', '.+');