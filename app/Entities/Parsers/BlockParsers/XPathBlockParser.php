<?php

namespace App\Entities\Parsers\BlockParsers;

use App\Entities\Parsers\BlockParsers\AbstractBlockParser;
use App\Entities\Parsers\Interfaces\IBlockParser;
use App\Entities\Parsers\UrlParsers\AbstractUrlParser;
use Exception;
use DOMNodeList;

/**
 * Content parser based on XPath
 */
class XPathBlockParser extends AbstractBlockParser implements IBlockParser {
    public function __construct(AbstractUrlParser $urlParser, int $linesCount = 10)
    {
        parent::__construct($urlParser, $linesCount);
    }

    /**
     * Searches for DOM nodes by the given selector
     *
     * @return DOMNodeList|null
     */
    public function getBlockContent(string $selector): ?DOMNodeList
    {
        $contentBody = $this->urlParser->getUrlContentBody();

        if ($contentBody === null) {
            throw new Exception('No content received from the given URL.');
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHTML($contentBody);

        if ($dom === null) {
            throw new Exception('DOM is empty and can\'t be parsed');
        }

        $this->xpath = new \DOMXPath($dom);

        $domBlocks = $this->xpath->query($selector);

        return $domBlocks;
    }
}