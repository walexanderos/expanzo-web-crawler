<?php
require '../vendor/autoload.php';

use JamiuJimoh\Crawler\ExCrawlerObserver;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

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

foreach ($urls as $url) {
    Crawler::create()
        ->ignoreRobots()
        //->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new ExCrawlerObserver())
        ->setCrawlProfile(new CrawlInternalUrls($url))
        ->setMaximumResponseSize(1024 * 1024 * 5)
        ->setConcurrency(1)
        ->setTotalCrawlLimit(10) 
        ->setDelayBetweenRequests(100)
        ->startCrawling($url);
}

echo 'Extracting completed';


