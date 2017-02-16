<?php

namespace App\Router;

use Symlex\Router\RestRouter as SymlexRestRouter;

/**
 * @see https://github.com/lastzero/symlex#routing-and-rendering
 */
class RestRouter extends SymlexRestRouter
{
    use SessionTrait;
}