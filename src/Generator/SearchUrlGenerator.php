<?php

namespace EdmondsCommerce\MagentoLoadTester\Generator;

class SearchUrlGenerator implements UrlGeneratorInterface
{
    protected $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
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

    public function getUrl() : string
    {
        $query = urlencode(implode(' ', array(
            $this->generateQueryString(),
            $this->generateQueryString(),
            $this->generateQueryString()
        )));

        return $this->baseUrl . '/' . $this->getSearchUrl() . $query;
    }

    public function getPost() : array
    {
        return [];
    }
}