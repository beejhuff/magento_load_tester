#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

use EdmondsCommerce\MagentoLoadTester\Command\SearchCommand;
use EdmondsCommerce\MagentoLoadTester\Command\SitemapCommand;

$application = new Application();

$application->add(new SearchCommand());
$application->add(new SitemapCommand());

$application->run();