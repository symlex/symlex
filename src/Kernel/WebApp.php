<?php

namespace App\Kernel;

use DIMicroKernel\Kernel;

/**
 * @author Michael Mayer <michael@lastzero.net>
 * @license MIT
 */
class WebApp extends Kernel
{
    protected $urlPrefix = '';

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

    public function getUrlPrefix($urlPrefixPostfix = '')
    {
        return $this->urlPrefix . $urlPrefixPostfix;
    }

    public function setUrlPrefix($urlPrefix)
    {
        $this->urlPrefix = $urlPrefix;
    }

    protected function setUp()
    {
        $container = $this->getContainer();

        $container->get('router.error')->route();
        $container->get('router.rest')->route($this->getUrlPrefix('/api'), 'controller.rest.');
        $container->get('router.twig')->route($this->getUrlPrefix(), 'controller.web.');
    }
}