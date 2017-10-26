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

    public function runTest($maxNumberOfUrlsToTest)
    {
        echo "Creating test with max ($maxNumberOfUrlsToTest) URLs\n";

        $curlHandles = array();
        $testUrls = array();
        $baseUrl = $this->getConfig()->getBaseUrl();

        $multi = curl_multi_init();

        echo "Configuring\n";

        $numberOfConfiguredRequests = 0;
        for ($i = 0; $i < $maxNumberOfUrlsToTest; $i++) {
            $url = $this->getUrlGenerator()->getUrl($baseUrl);
            if (is_null($url)) {
                echo "[NOTICE] Consumed all URLs\n";
                break;
            }
            $testUrls[$i] = $url;
            $curlHandles[$i] = curl_init();
            curl_setopt($curlHandles[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandles[$i], CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlHandles[$i], CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandles[$i], CURLOPT_URL, $testUrls[$i]);
            curl_setopt($curlHandles[$i], CURLOPT_TIMEOUT, $this->getConfig()->getCurlTimeout());
            curl_setopt($curlHandles[$i], CURLOPT_CONNECTTIMEOUT, $this->getConfig()->getCurlConnectTimeout());
            curl_setopt($curlHandles[$i], CURLOPT_USERAGENT, $this->getConfig()->getUserAgent());
            curl_multi_add_handle($multi, $curlHandles[$i]);

            $numberOfConfiguredRequests++;
        }

        echo "Running\n";

        $startTime = microtime(true);

        do {
            curl_multi_exec($multi, $active);
        }
        while ($active > 0);

        $failedRequestCount = 0;
        foreach ($curlHandles as $i => $curlHandle) {
            $info = curl_getinfo($curlHandle);

            if (! in_array($info['http_code'], array(200, 301))) {
                echo "[FAILED REQUEST]\n";
                echo "URL: {$testUrls[$i]}\n";
                echo "Http Code: {$info['http_code']}\n";

                $failedRequestCount++;
            }
        }

        echo "\n";
        echo "($failedRequestCount) out of ($numberOfConfiguredRequests) requests failed\n";

        unset($multi);

        $endTime = microtime(true);
        $deltaTime = $endTime - $startTime;

        echo "Test ran for $deltaTime seconds\n";
    }
}