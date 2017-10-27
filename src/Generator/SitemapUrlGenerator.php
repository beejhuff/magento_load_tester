<?php

namespace EdmondsCommerce\MagentoLoadTester\Generator;

class SitemapUrlGenerator implements UrlGeneratorInterface
{
    protected $sitemapUrls;

    protected $siteUrls = [];

    public function __construct($sitemapUrls)
    {
        $this->sitemapUrls = $sitemapUrls;

        $this->harvestSiteUrls();
    }

    protected function getSitemapContents($url)
    {
        return json_decode(json_encode(simplexml_load_file($url) ), TRUE);
    }

    protected function harvestSiteUrls()
    {
        foreach ($this->sitemapUrls as $sitemapUrl) {
            $sitemapItems = $this->getSitemapContents($sitemapUrl);

            foreach ($sitemapItems['url'] as $item) {
                if (isset($item['loc'])) {
                    $this->siteUrls[] = $item['loc'];
                }
            }
        }

        if (count($this->siteUrls) === 0) {
            $msg = 'No sitemap URLs were harvested. Load testing cannot be completed.';
            throw new \Exception($msg);
        }
    }

    public function getUrl() : string
    {
        $randomIndex = array_rand($this->siteUrls);
        return $this->siteUrls[$randomIndex];
    }

    public function getPost() : array
    {
        return [];
    }
}