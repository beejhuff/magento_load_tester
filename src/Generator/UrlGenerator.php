<?php

namespace EdmondsCommerce\MagentoLoadTester\Generator;

class UrlGenerator implements UrlGeneratorInterface
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getPost() : array
    {
        return [];
    }
}