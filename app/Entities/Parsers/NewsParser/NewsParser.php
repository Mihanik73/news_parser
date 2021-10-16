<?php

namespace App\Entities\Parsers\NewsParser;

use Exception;
use App\Entities\Parsers\AbstractContentParser;
use App\Entities\Parsers\BlockParsers\AbstractBlockParser;

class NewsParser extends AbstractContentParser {
    protected AbstractBlockParser    $blockParser;
    private   int                    $newsCount = 0;

    public function __construct(AbstractBlockParser $blockParser, int $newsCount = 15)
    {
        parent::__construct($blockParser);

        $this->newsCount = $newsCount;
    }

    public function getNewsFromUrlContent(string $selector)
    {
        $blocksContent = $this->blockParser->getBlockContent($selector);

        if ($blocksContent === null) {
            throw new Exception('No news blocks have been found by the given selector.');
        }

        $news = $this->blockParser->parseNewsContent($blocksContent, $this->newsCount);

        return $news;
    }
}