<?php

namespace App\Entities\Parsers\UrlParsers;

use App\Entities\Parsers\UrlParsers\AbstractUrlParser;
use Exception;

/**
 * Receives website's content from the given URL using CURL
 */
class CurlUrlParser extends AbstractUrlParser {
    private string $url = '';

    public function __construct(string $url)
    {
        $this->url = $url ?? '';
    }

    function getUrlContentBody(): string
    {
        $body = null;

        if (empty($this->url)) {
            throw new Exception('URL is not defined.');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);

        $urlContentData = curl_exec($ch);

        $body = $this->getBodyFromPageContent($urlContentData);

        curl_close($ch);

        return $body;
    }

    /**
     * Parses content and returns only page body
     *
     * @param string $content
     *
     * @return string
     */
    private function getBodyFromPageContent(string $content): string
    {
        return @(explode("\r\n\r\n", $content, 2))[1];
    }
}
