<?php

namespace App\Kernel;

use Exception;
use DIMicroKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Michael Mayer <michael@liquidbytes.net>
 * @license MIT
 */
class WebApp extends Kernel
{
    protected string $urlPrefix = '';

    public function __construct($appPath, $debug = false)
    {
        parent::__construct('web', $appPath, $debug);
    }

    public function init()
    {
        if ($this->debug) {
            ini_set('display_errors', 1);
        }
    }

    /**
     * Runs the web app and returns response object
     *
     * @param Request $request The request object
     *
     * @throws Exception
     * @return Response
     */
    public function handle(Request $request)
    {
        return $this->getApplication()->handle($request);
    }

    /**
     * Resets application / container state
     */
    public function reboot() {
        $this->container = null;
        $this->appInitialized = false;
    }

    public function getUrlPrefix(string $urlPrefixPostfix = ''): string
    {
        return $this->urlPrefix . $urlPrefixPostfix;
    }

    public function setUrlPrefix(string $urlPrefix)
    {
        $this->urlPrefix = $urlPrefix;
    }

    protected function setUp()
    {
        $container = $this->getContainer();

        // The error router catches errors and displays them as error pages
        $container->get('router.error')->route();

        // Routing for REST API calls
        $container->get('router.rest')->route($this->getUrlPrefix('/api/v1'), 'controller.rest.v1.');

        // All other requests are routed to a default controller action (client-side routing e.g. with Vue.js)
        $container->get('router.twig_default')->route($this->getUrlPrefix(), 'controller.web.index', 'index');

        // Uncomment the following line to enable server-side routing
        // $container->get('router.twig')->route($this->getUrlPrefix(), 'controller.web.');
    }
}