<?php

namespace App\Router;

use Symlex\Router\Web\ErrorRouter as SymlexErrorRouter;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\LoggerTrait;

/**
 * @author Michael Mayer <michael@liquidbytes.net>
 * @license MIT
 * @see http://docs.symlex.org/en/latest/framework/routing/
 */
class ErrorRouter extends SymlexErrorRouter
{
    use LoggerTrait;

    protected function logException(\Exception $e) {
        $logMessage = get_class($e) . ' in ' . $e->getFile() . ' line ' . $e->getLine() . ': ' . $e->getMessage();
        $this->logError($logMessage);
    }

    protected function jsonError(\Exception $exception, int $httpCode): Response {
        $this->logException($exception);

        return parent::jsonError($exception, $httpCode);
    }

    protected function htmlError(\Exception $exception, int $httpCode): Response {
        $this->logException($exception);

        return parent::htmlError($exception, $httpCode);
    }
}