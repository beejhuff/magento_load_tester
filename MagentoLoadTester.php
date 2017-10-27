#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

use EdmondsCommerce\MagentoLoadTester\Command\SearchCommand;

$application = new Application();

$application->add(new SearchCommand());

$application->run();