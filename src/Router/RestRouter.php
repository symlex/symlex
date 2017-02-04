<?php

namespace App\Router;

use Symlex\Router\RestRouter as SymlexRestRouter;

class RestRouter extends SymlexRestRouter
{
    use SessionTrait;
}