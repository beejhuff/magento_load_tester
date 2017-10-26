<?php

namespace EdmondsCommerce\MagentoLoadTester;

class LoadTester
{
    private $urlGenerator;

    private $config;

    public function __construct(ConfigInterface $config, UrlGeneratorInterface $urlGenerator)
    {
        $this->config = $config;
        $this->urlGenerator = $urlGenerator;
    }

    protected function getUrlGenerator()
    {
        return $this->urlGenerator;
    }

    protected function getConfig()
    {
        return $this->config;
    }

    public function runTest($requestCount)
    {
        $curlHandles = array();
        $testUrls = array();
        $baseUrl = $this->getConfig()->getBaseUrl();

        $multi = curl_multi_init();

        for ($i = 0; $i < $requestCount; $i++) {
            $url = $baseUrl . '/'. $this->getUrlGenerator()->getUrl();
            $testUrls[$i] = $url;
            $curlHandles[$i] = curl_init();
            curl_setopt($curlHandles[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandles[$i], CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlHandles[$i], CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandles[$i], CURLOPT_URL, $testUrls[$i]);
            curl_setopt($curlHandles[$i], CURLOPT_TIMEOUT, $this->getConfig()->getCurlTimeout());
            curl_setopt($curlHandles[$i], CURLOPT_CONNECTTIMEOUT, $this->getConfig()->getCurlConnectTimeout());
            curl_setopt($curlHandles[$i], CURLOPT_USERAGENT, $this->getConfig()->getUserAgent());

            if (count($post = $this->getUrlGenerator()->getPost()) > 0) {
                $postFields = http_build_query($post, '', '&');
                curl_setopt($curlHandles[$i], CURLOPT_POST, 1);
                curl_setopt($curlHandles[$i], CURLOPT_POSTFIELDS, $postFields);
            }

            curl_multi_add_handle($multi, $curlHandles[$i]);
        }

        do {
            curl_multi_exec($multi, $active);
        }
        while ($active > 0);

        $results = new Results();

        foreach ($curlHandles as $i => $curlHandle) {
            $info = curl_getinfo($curlHandle);

            $results->addRequestTime($info['total_time']);

            if (! in_array($info['http_code'], array(200, 301))) {
                $results->addFailedRequest(
                    $info['url'],
                    $info['http_code']
                );
            }
        }

        unset($multi);

        return $results;
    }
}