<?php

use Symfony\Component\HttpFoundation\Request;
use Exception\NotFoundException;

$app->match('/api/{path}', function ($path, Request $request) use ($app) {
    $prefix = strtolower($request->getMethod());
    $parts = explode('/', $path);

    $controller = array_shift($parts);

    $subResources = '';
    $params = array();

    $count = count($parts);

    if ($count == 0) {
        $prefix = 'c' . $prefix;
    }

    for ($i = 0; $i < $count; $i++) {
        $params[] = $parts[$i];

        if (isset($parts[$i + 1])) {
            $i++;
            $subResources .= ucfirst($parts[$i]);
        }
    }

    $params[] = $request;
    $actionName = $prefix . $subResources . 'Action';

    $controllerService = strtolower($controller) . '.api.controller';

    if(!isset($app[$controllerService])) {
        throw new NotFoundException ('API controller service not found: ' . $controllerService);
    }

    $controllerInstance = $app[$controllerService];

    if(!method_exists($controllerInstance, $actionName)) {
        throw new NotFoundException ('API controller method not found: ' . $actionName);
    }

    $result = call_user_func_array(array($controllerInstance, $actionName), $params);

    return $app->json($result);
})->assert('path', '.+');