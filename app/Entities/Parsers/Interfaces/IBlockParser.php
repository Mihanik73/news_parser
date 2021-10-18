<?php

namespace App\Entities\Parsers\Interfaces;

use DOMNodeList;

interface IBlockParser
{
    /**
     * Receives block content by the given selector
     *
     * @param string $selector
     *
     * @return DOMNodeList|null
     */
    function getBlockContent(string $selector): ?DOMNodeList;
}
