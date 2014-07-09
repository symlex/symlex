<?php

namespace App\Controller\Api;

use Component\Controller\AbstractController;
use Silex\Application;

class ErrorController extends AbstractController {
    protected $exceptionMessages;

    public function setExceptionMessages(array $exceptionMessages)
    {
        $this->exceptionMessages = $exceptionMessages;
    }

    public function errorAction($exception, $code)
    {
        if($this->app['debug']) {
            $message = $exception->getMessage();

            if(empty($message) && isset($this->exceptionMessages[$code])) {
                $message = $this->exceptionMessages[$code];
            }

            $class = get_class($exception);
            $trace = $exception->getTrace();
        } else {
            if(isset($this->exceptionMessages[$code])) {
                $message = $this->exceptionMessages[$code];
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

        return $this->json($result, $code);
    }
}