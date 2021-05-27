<?php

namespace App\Twig\Extension;

class Md5sum extends \Twig_Extension
{
    protected $basePath;

    public function __construct($basePath) {
        $this->basePath = realpath($basePath);
    }

    public function getFilters()
    : array {
        return array(
            new \Twig_SimpleFilter('md5sum', array($this, 'md5sum')),
        );
    }

    public function md5sum(string $filename)
    {
        return md5_file($this->basePath . '/' . $filename);
    }

    public function getName()
    : string {
        return 'md5sum';
    }
}