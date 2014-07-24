<?php

namespace App\Router;

use Sympathy\Silex\Router\RestRouter as SympathyRestRouter;

class RestRouter extends SympathyRestRouter
{
    use SessionTrait;
}