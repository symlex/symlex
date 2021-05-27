<?php

namespace App\Router;

use App\Traits\SessionTrait;
use Doctrine\ActiveRecord\Search\SearchResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symlex\Exception\MethodNotAllowedException;
use Symlex\Exception\AccessDeniedException;
use Symlex\Router\Web\RouterAbstract;

/**
 * @author Michael Mayer <michael@liquidbytes.net>
 * @license MIT
 * @see http://docs.symlex.org/en/latest/framework/routing/
 */
class RestRouter extends RouterAbstract
{
    use SessionTrait;

    public function route(string $routePrefix = '/api', string $servicePrefix = 'controller.rest.', string $servicePostfix = '')
    {
        $app = $this->app;

        $handler = function (Request $request, string $path) use ($servicePrefix, $servicePostfix) {
            $this->getSession()->setRequest($request);

            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }

            $method = $request->getMethod();

            $prefix = strtolower($method);
            $parts = explode('/', $path);

            $controller = array_shift($parts);

            $subResources = '';
            $params = array();

            $count = count($parts);

            if ($count % 2 == 0 && $prefix != 'post') {
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

            $controllerService = $servicePrefix . strtolower($controller) . $servicePostfix;

            $controllerInstance = $this->getController($controllerService);

            if ($method === Request::METHOD_HEAD && !method_exists($controllerInstance, $actionName)) {
                $actionName = 'get' . $subResources . 'Action';

                if ($count % 2 == 0) {
                    $actionName = 'c' . $actionName;
                }
            }

            if (!method_exists($controllerInstance, $actionName)) {
                throw new MethodNotAllowedException ('Method ' . $method . ' not supported');
            }

            if (!$this->hasPermission($request)) {
                throw new AccessDeniedException ('Access denied');
            }

            $result = call_user_func_array(array($controllerInstance, $actionName), $params);

            if (!$result) {
                $httpCode = 204;
            } elseif ($method == 'POST') {
                $httpCode = 201;
            } else {
                $httpCode = 200;
            }

            $response = $this->getResponse($result, $httpCode);

            return $response;
        };

        $app->match($routePrefix . '/{path}', $handler, ['path' => '.+']);
    }

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