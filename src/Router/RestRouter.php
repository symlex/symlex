<?php

namespace App\Router;

use Symfony\Component\HttpFoundation\Response;
use Symlex\Router\Web\RestRouter as SymlexRestRouter;
use Doctrine\ActiveRecord\Search\SearchResult;
use App\Traits\SessionTrait;

/**
 * @see https://github.com/symlex/symlex#routing-and-rendering
 */
class RestRouter extends SymlexRestRouter
{
    use SessionTrait;

    protected function getResponse($result, int $httpCode): Response
    {
        $headers = array();

        if (is_object($result)) {
            if ($result instanceof Response) {
                // If controller returns Response object, return it directly
                return $result;
            } elseif ($result instanceof SearchResult) {
                // Add special headers to search results
                $headers['X-Result-Total'] = $result->getTotalCount();
                $headers['X-Result-Order'] = $result->getSortOrder();
                $headers['X-Result-Count'] = $result->getSearchCount();
                $headers['X-Result-Offset'] = $result->getSearchOffset();

                $result = $result->getAllResultsAsArray();
            }
        }

        return $this->app->json($result, $httpCode, $headers);
    }
}