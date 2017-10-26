<?php

namespace EdmondsCommerce\MagentoLoadTester\Generator;

class MagentoSearchUrlGenerator implements UrlGeneratorInterface
{
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

        return $this->getSearchUrl() . $query;
    }

    public function getPost() : array
    {
        return [];
    }
}