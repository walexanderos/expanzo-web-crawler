<?php
namespace JamiuJimoh\Crawler;

use Spatie\Crawler\CrawlObservers\CrawlObserver;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ExCrawlerObserver extends CrawlObserver {
  
    private $contacts;
    private $url;

    public function __construct() {
        $this->contacts = [];
    }
      
    
    /*
     * Called when the crawler will crawl the url.
     */

    public function willCrawl(UriInterface $url,?string $linkText): void
    {
        $this->url = $url;
        log_message("crawling => {$url}");
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        UriInterface $foundOnUrl = null,
        string $linkText = null,
    ): void
    {
        $body = $response->getBody();
        
        if ($body->getSize()) {
            $extractedContacts = extractContacts($body);
            $this->contacts = array_merge($this->contacts, $extractedContacts);
        }
    }

     /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        UriInterface $foundOnUrl = null,
        string $linkText = null,
    ): void
    {
        log_message("Error occured on: {$this->url} => " .$requestException->getMessage());
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        // check if numbers were extracted then save/display them
        $total = count($this->contacts);
        if ($total) {
            saveAndNormalizeContacts($this->contacts, $this->url);
        }
        log_message('crawling done: '. $total);
    }
}