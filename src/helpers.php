<?php

function log_message($message){
    $exception = date('Y-m-d H:i:s') . ' - ' . $message . "\n";
    error_log($exception, 3, '../logs/error.log');
}

function extractContacts(string $body): array
{
    $contacts = [];
    $doc = new DOMDocument();
    libxml_use_internal_errors(true); 
    $doc->loadHTML($body);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);

    $phoneXPath = "//a[contains(@href, 'tel:')] | text()[starts-with(normalize-space(), '+')]";

    // Find phone numbers and emails using XPath queries
    $phoneElements = $xpath->query($phoneXPath);

    // Extract and store phone numbers
    foreach ($phoneElements as $phoneElement) {
        $phone = $phoneElement->textContent;
        $contacts[] = $phone;
    }

    return $contacts;
}

function saveAndNormalizeContacts(array $contacts, ?string $url){
    if ($url) {
        echo "Contacts from " . $url, PHP_EOL;
    }

    foreach ($contacts as $contact) {
        if ($contact) {
            $contact = filter_var($contact, FILTER_SANITIZE_NUMBER_INT);
            if (!str_starts_with($contact, '+')) {
                $contact = "+" . $contact;
            }
            echo $contact;
            echo PHP_EOL;
        }
    }
}
