<?php

namespace App\Entities\Parsers\UrlParsers;

use App\Entities\Parsers\Interfaces\IUrlParser;

abstract class AbstractUrlParser implements IUrlParser {
    private string $url = '';

    public function __construct(string $url)
    {
        $this->url = $url ?? '';
    }

    /**
     * Receives content from the website by the given URL
     *
     * @return string
     */
    abstract function getUrlContentBody(): string;
}