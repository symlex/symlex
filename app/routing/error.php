<?php

$app->error(function (\Exception $e, $code) use ($app) {
    $request = $app['request'];
    $exceptionClass = get_class($e);

    if(isset($app['exception.codes']) && isset($app['exception.codes'][$exceptionClass])) {
        $code = $app['exception.codes'][$exceptionClass];
    }

    if (0 === strpos($request->headers->get('Accept'), 'application/json') && isset($app['error.api.controller'])) {
        return $app['error.api.controller']->errorAction($e, $code);
    }

    return $app['error.web.controller']->errorAction($e, $code);
});