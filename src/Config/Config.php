<?php

namespace EdmondsCommerce\MagentoLoadTester\Config;

class Config implements ConfigInterface
{
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getCurlConnectTimeout()
    {
        return 60;
    }

    public function getCurlTimeout()
    {
        return 60;
    }

    public function getUserAgent()
    {
        // Chrome
        return 'Mozilla/5.0 (X11; Fedora; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36';
    }
}