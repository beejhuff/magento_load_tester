<?php

namespace EdmondsCommerce\MagentoLoadTester;

/**
 * Interface UrlGeneratorInterface
 * @package EdmondsCommerce\MagentoLoadTester
 *
 * The URL generator should provide an infinite supply of URLs
 * and POST data for load testing.
 */
interface UrlGeneratorInterface
{
    /**
     * @return string   URL to be tested
     */
    public function getUrl() : string;

    /**
     * @return array    All POST fields to be sent with the
     *                  request (empty array if GET request).
     *                  This should be in the form:
     *                      ['var1' => 'value1', 'var2' => 'value2']
     */
    public function getPost() : array ;
}