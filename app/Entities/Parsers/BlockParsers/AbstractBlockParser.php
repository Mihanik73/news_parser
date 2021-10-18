<?php

namespace App\Entities\Parsers\BlockParsers;

use App\Entities\Parsers\Interfaces\IBlockParser;
use App\Entities\Parsers\UrlParsers\AbstractUrlParser;
use DOMNodeList;

abstract class AbstractBlockParser implements IBlockParser {
    protected string            $blockSelector;
    protected AbstractUrlParser $urlParser;
    protected int               $linesCount;
    protected                   $blockContentParser;

    public function __construct(AbstractUrlParser $urlParser, int $linesCount)
    {
        $this->urlParser  = $urlParser;
        $this->linesCount = $linesCount;
    }

    abstract function getBlockContent(string $selector): ?DOMNodeList;
}