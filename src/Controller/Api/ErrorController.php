<?php

namespace Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function errorAction($exception, $code)
    {
        if($this->app['debug']) {
            $message = $exception->getMessage();

            if(empty($message) && isset($this->app['exception.messages'][$code])) {
                $message = $this->app['exception.messages'][$code];
            }

            $class = get_class($exception);
            $trace = $exception->getTrace();
        } else {
            if(isset($this->app['exception.messages'][$code])) {
                $message = $this->app['exception.messages'][$code];
            } else {
                $message = $exception->getMessage();
            }

            $class = 'Exception';
            $trace = array();
        }

        $result = array(
            'message' => $message,
            'code' => $code,
            'class' => $class,
            'trace' => $trace
        );

        return $this->app->json($result, $code);
    }
}