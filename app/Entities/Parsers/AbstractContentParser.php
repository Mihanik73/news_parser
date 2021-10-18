<?php

namespace App\Entities\Parsers;

use App\Entities\Parsers\BlockParsers\AbstractBlockParser;

abstract class AbstractContentParser {
    public function __construct(AbstractBlockParser $blockParser)
    {
        $this->blockParser = $blockParser;
    }

    abstract function getContentBySelector(string $selector): array;
}