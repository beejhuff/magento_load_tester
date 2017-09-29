# Magento Load Tester
## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)

A Magento load testing framework put together by Edmonds Commerce especially for putting
Magento websites through their paces. Using this tool you determine the maximum number
of concurrent users your site can handle. Using this together with your site analytics
you can determine how well your site can handle events like black Friday.

### Usage ###

You can create a simple load testing script as follows:

```php
<?php

require_once "UrlGeneratorInterface.php";
require_once "MagentoSearchUrlGenerator.php";
require_once "ConfigInterface.php";
require_once "Config.php";
require_once "LoadTester.php";

$baseUrl      = '<put your sites base URL here>';
$config       = new \loadtest\Config($baseUrl);
$urlGenerator = new \loadtest\MagentoSearchUrlGenerator();
$tester       = new \loadtest\LoadTester($config, $urlGenerator);

$tester->runTest(300);
```

### Extending the framework ###

#### URL Generation ####

The current framework can easily be extended by adding new URL generator classes. These classes
simply need to extend the `UrlGeneratorInterface` interface and provide the system with a stream
of URLs to test.