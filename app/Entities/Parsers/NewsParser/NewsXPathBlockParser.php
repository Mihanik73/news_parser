<?php

namespace App\Entities\Parsers\NewsParser;

use DOMNodeList;
use DOMElement;
use App\Entities\Parsers\UrlParsers\CurlUrlParser;
use App\Entities\Parsers\BlockParsers\XPathBlockParser;
use App\Entities\Parsers\Interfaces\IBlockParser;

class NewsXPathBlockParser extends XPathBlockParser implements IBlockParser {

    public function __construct(CurlUrlParser $urlParser, int $linesCount = 10)
    {
        parent::__construct($urlParser, $linesCount);
    }

    /**
     * Parses DOM node list and forms array with news data
     *
     * @param DOMNodeList $blocks
     *
     * @return array
     */
    public function parseNewsContent(DOMNodeList $blocks, int $newsCount): array
    {
        $news = [];

        foreach ($blocks as $block) {
            if (!empty($news) && count($news) >= $newsCount) {
                break;
            }

            $newsDateData = $this->getNewsCategoryAndTime($block);

            $news[] = [
                'url'      => $block->getAttribute('href'),
                'title'    => $this->getNewsTitle($block),
                'category' => $newsDateData['category'],
                'time'     => $newsDateData['time']
            ];
        }

        return $news;
    }

    /**
     * Get title for a piece of news
     *
     * @param DOMElement $newsBlock
     *
     * @return string
     */
    private function getNewsTitle(DOMElement $newsBlock): string
    {
        $newsBlocks = $this->xpath->query(".//span[contains(@class, 'news-feed__item__title')]", $newsBlock);

        $title = '';
        foreach ($newsBlocks as $childBlock) {
            if (!empty($childBlock->textContent)) {
                $title = trim($childBlock->textContent);

                break;
            }
        }

        return $title;
    }

    /**
     * Parses date block and gets news category and time
     *
     * @param DOMElement $newsBlock
     *
     * @return array
     */
    private function getNewsCategoryAndTime(DOMElement $newsBlock): array
    {
        $newsBlocks = $this->xpath->query(".//span[contains(@class, 'news-feed__item__date-text')]", $newsBlock);

        $newsDateData = [];
        foreach ($newsBlocks as $child_block) {
            if (!empty($child_block->textContent)) {
                $dateData = trim($child_block->textContent);

                $matches = [];
                $pattern = '/^(.*),.+(\d{2}:\d{2})$/';
                $result = preg_match($pattern, $dateData, $matches);

                if ($result && !empty($matches[1]) && !empty($matches[2])) {
                    $newsDateData = [
                        'category' => $matches[1],
                        'time'     => $matches[2]
                    ];
                }

                break;
            }
        }

        return $newsDateData;
    }
}