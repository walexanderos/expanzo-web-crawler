<?php
require '../vendor/autoload.php';

use JamiuJimoh\Crawler\ExCrawlerObserver;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

// targeted sites
$urls = [
    'https://www.vetropack.com/en',
    'https://www.kniha-jizd-zdarma.cz/cs/',
    'https://www.logbookie.eu/cs/',
    'https://www.crm-zdarma.cz/cs/',
    'https://www.cez.cz/cs/',
    'https://igloonet.cz/',
    'https://portal.expanzo.com/',
];

echo 'Extracting info, please wait....', PHP_EOL;

// Instatiate crawler for each url
foreach ($urls as $url) {
    Crawler::create()
        ->ignoreRobots()
        ->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new ExCrawlerObserver()) // Use custom observer script extending CrawlerObserver
        ->setCrawlProfile(new CrawlInternalUrls($url))
        ->setMaximumResponseSize(1024 * 1024 * 5) // Maximum response size of 5mb
        ->setTotalCrawlLimit(10) // Maximum numbers of urls to crawl should not exceed 10
        ->setDelayBetweenRequests(100) // wait every 100ms before each request
        ->startCrawling($url);
}

echo 'Extraction completed';


