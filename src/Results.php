<?php

namespace EdmondsCommerce\MagentoLoadTester;

class Results
{
    private $failedRequests = [];

    private $totalRequestTime = 0;

    public function addFailedRequest(string $url, int $httpCode)
    {
        $this->failedRequests[] = [
            'url' => $url,
            'http_code' => $httpCode
        ];
    }

    public function getFailedRequests()
    {
        return $this->failedRequests;
    }

    public function getNumberOfFailedRequests()
    {
        return count($this->failedRequests);
    }

    public function addRequestTime(float $time)
    {
        $this->totalRequestTime += $time;
    }

    public function getTotalRequestTime()
    {
        return $this->totalRequestTime;
    }
}