<?php

namespace EdmondsCommerce\MagentoLoadTester\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use EdmondsCommerce\MagentoLoadTester\Config\Config;
use EdmondsCommerce\MagentoLoadTester\Generator\SitemapUrlGenerator;
use EdmondsCommerce\MagentoLoadTester\LoadTester;

class SitemapCommand extends AbstractCommand
{
    protected $sitemapUrls;

    protected function configure()
    {
        parent::configure();

        $this->setName('load-test:sitemap')
            ->setDescription('Load test the site using random URLs selected from the sites sitemap(s).')
            ->setHelp('TODO');

        $this->addArgument(
            'sitemap_urls',
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            'A list of sitemap URLs for the load tester to harvest.'
        );
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->sitemapUrls = $input->getArgument('sitemap_urls');

        parent::initialize($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '',
            "Creating sitemmap load test with a request count of '$this->requestCount'",
            ''
        ]);

        $config       = new Config();
        $urlGenerator = new SitemapUrlGenerator($this->sitemapUrls);
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