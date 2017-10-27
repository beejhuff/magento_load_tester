<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected $baseUrl;

    protected $requestCount;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->requestCount = $input->getArgument('request_count');

        parent::initialize($input, $output);
    }

    protected function configure()
    {
        $this->addArgument(
            'request_count',
            InputArgument::REQUIRED,
            'The number of concurrent requests you wish to hit the site with.'
        );
    }

    protected function outputFailedRequests(OutputInterface $output, array $failedRequests)
    {
        $failedRequestsTable = new \Console_Table();

        $failedRequestsTable->setHeaders([
            'url', 'http_code'
        ]);

        foreach ($failedRequests as $failedRequest) {
            $failedRequestsTable->addRow([
                $failedRequest['url'],
                $failedRequest['http_code']
            ]);
        }

        $output->writeln($failedRequestsTable->getTable());
    }
}