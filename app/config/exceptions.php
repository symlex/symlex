<?php

$app['exception.codes'] = array(
    'InvalidArgumentException' => 400,
    'Exception\NotFoundException' => 404,
    'Exception' => 500
);

$app['exception.messages'] = array(
    400 => 'Bad request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    500 => 'Looks like something went wrong!'
);