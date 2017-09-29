<?php

namespace loadtest;

class MagentoSearchUrlGenerator
    implements UrlGeneratorInterface
{
    protected function generateQueryString()
    {
        $timestamp = time();
        $randomNumber = rand();
        return md5($timestamp . $randomNumber);
    }

    public function getSearchUrl()
    {
        return 'catalogsearch/result/?q=';
    }

    public function getUrl($baseUrl)
    {
        $query = urlencode(implode(' ', array(
            $this->generateQueryString(),
            $this->generateQueryString(),
            $this->generateQueryString()
        )));

        return $baseUrl . '/' . $this->getSearchUrl() . $query;
    }
}