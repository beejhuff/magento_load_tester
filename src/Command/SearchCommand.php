<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use EdmondsCommerce\MagentoLoadTester\Config;
use EdmondsCommerce\MagentoLoadTester\MagentoSearchUrlGenerator;
use EdmondsCommerce\MagentoLoadTester\LoadTester;

class SearchCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('load-test:search')
            ->setDescription('Load test the site using random search queries.')
            ->setHelp('TODO');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config       = new Config($this->baseUrl);
        $urlGenerator = new MagentoSearchUrlGenerator();
        $tester       = new LoadTester($config, $urlGenerator);

        $tester->runTest($this->requestCount);
    }
}