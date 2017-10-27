<?php

namespace EdmondsCommerce\MagentoLoadTester\Config;

interface ConfigInterface
{
    /**
     * @return mixed
     */
    public function getBaseUrl();

    /**
     * @return mixed
     */
    public function getCurlTimeout();

    /**
     * @return mixed
     */
    public function getCurlConnectTimeout();

    /**
     * @return mixed
     */
    public function getUserAgent();
}