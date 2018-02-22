<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use EdmondsCommerce\MagentoLoadTester\Generator\UrlGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use EdmondsCommerce\MagentoLoadTester\Config\Config;
use EdmondsCommerce\MagentoLoadTester\LoadTester;

class UrlCommand extends AbstractCommand
{
    protected $urlListFile;

    protected function configure()
    {
        parent::configure();

        $this->setName('load-test:url')
            ->setDescription('Load test the site using custom URL.')
            ->setHelp('TODO');

        $this->addArgument(
            'url',
            InputArgument::REQUIRED,
            'A txt file that contains a list of URLs for the load tester to harvest.'
        );
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->urlListFile = $input->getArgument('url');

        parent::initialize($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '',
            "Creating custom URL load test with a request count of '$this->requestCount'",
            ''
        ]);

        $config       = new Config();
        $urlGenerator = new UrlGenerator($this->urlListFile);
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