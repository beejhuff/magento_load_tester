<?php

namespace EdmondsCommerce\MagentoLoadTester\Generator;

class SearchUrlGenerator implements UrlGeneratorInterface
{
    protected $baseUrls;

    public function __construct($baseUrls)
    {
        $this->baseUrls = $baseUrls;
    }

    protected function generateQueryString()
    {
        $timestamp = time();
        $randomNumber = rand();
        return md5($timestamp . $randomNumber);
    }

    protected function getSearchUrl()
    {
        return 'catalogsearch/result/?q=';
    }

    protected function getBaseUrl()
    {
        $randomIndex = array_rand($this->baseUrls);
        return $this->baseUrls[$randomIndex];
    }

    public function getUrl() : string
    {
        $query = urlencode(implode(' ', array(
            $this->generateQueryString(),
            $this->generateQueryString(),
            $this->generateQueryString()
        )));

        return $this->getBaseUrl() . '/' . $this->getSearchUrl() . $query;
    }

    public function getPost() : array
    {
        return [];
    }
}