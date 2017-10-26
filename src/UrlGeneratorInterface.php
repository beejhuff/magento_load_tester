<?php

namespace EdmondsCommerce\MagentoLoadTester;

interface UrlGeneratorInterface
{
    /**
     * @param $baseUrl
     * @return string | null The URL to be tested or null if all URLs have been consumed
     */
    public function getUrl($baseUrl);
}