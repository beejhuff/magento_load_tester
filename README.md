# Magento Load Tester
## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)

A Magento load testing framework put together by Edmonds Commerce especially for putting
Magento websites through their paces.
 
Using this tool you can determine the maximum number of concurrent users your site can handle.
Using this information together with your sites analytics data you can determine how well
your site will handle events such as black Friday.

### Installation ###

It's as simple as:

```bash
git clone https://github.com/edmondscommerce/magento_load_tester.git
cd magento_load_tester
composer install
```

### Usage ###

#### General ####

Magento Load Tester is a command line tool and can be run using:

```bash
./MagentoLoadTester.php <command name> [args]...
```

You can get a list of available commands by running:

```bash
./MagentoLoadTester.php
```

#### Search ####

Magento Load Tester can test your site by starting up large numbers of search queries. To complete this type of testing
you simply need to provide your sites base URL (or multiple base URLs if you have multiple stores) and a request count.
The request count determines how many concurrent search queries will be completed on your site.

```bash
./MagentoLoadTester.php load-test:search <request_count> <base_urls> (<base_urls>)...
```

#### Sitemap ####

Magento Load Tester can also make use of your sites sitemap (or multiple sitemaps if you have multiple stores) to
test your site. The tool will select random URLs from the sitemap and access them.

```bash
./MagentoLoadTester.php load-test:sitemap <request_count> <sitemap_urls> (<sitemap_urls>)...
```

### Extending The Framework ###

In order to add new commands to the tool you need to add a URL generator and a new console command. Examples of these
can be seen in [src/Generator](src/Generator) and [src/Command](src/Command).