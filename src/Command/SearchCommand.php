<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use EdmondsCommerce\MagentoLoadTester\Config\Config;
use EdmondsCommerce\MagentoLoadTester\Generator\SearchUrlGenerator;
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
        $output->writeln([
            '',
            "Creating load test for '$this->baseUrl' with a request count of '$this->requestCount'",
            ''
        ]);

        $config       = new Config($this->baseUrl);
        $urlGenerator = new SearchUrlGenerator();
        $loadTester   = new LoadTester($config, $urlGenerator);

        $results = $loadTester->run($this->requestCount);

        $numberOfFailedRequests = $results->getNumberOfFailedRequests();
        $totalRequestTime = $results->getTotalRequestTime();

        $output->writeln([
            '[RESULTS]',
            '',
            "$numberOfFailedRequests out of $this->requestCount requests failed.",
            '',
            "It took a total of $totalRequestTime seconds to complete all requests.",
            '',
            '[FAILED REQUEST DETAILS]',
            ''
        ]);

        $this->outputFailedRequests($output, $results->getFailedRequests());
    }
}