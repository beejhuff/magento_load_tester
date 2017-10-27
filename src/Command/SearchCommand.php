<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use EdmondsCommerce\MagentoLoadTester\Config\Config;
use EdmondsCommerce\MagentoLoadTester\Generator\SearchUrlGenerator;
use EdmondsCommerce\MagentoLoadTester\LoadTester;

class SearchCommand extends AbstractCommand
{
    protected $baseUrls;

    protected function configure()
    {
        parent::configure();

        $this->setName('load-test:search')
            ->setDescription('Load test the site using random search queries.')
            ->setHelp('TODO');

        $this->addArgument(
            'base_urls',
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            'The base URL(s) for the site you wish to test'
        );
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->baseUrls = $input->getArgument('base_urls');

        parent::initialize($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '',
            "Creating search load test with a request count of '$this->requestCount'",
            ''
        ]);

        $config       = new Config();
        $urlGenerator = new SearchUrlGenerator($this->baseUrls);
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