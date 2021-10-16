<?php

namespace App\Entities\Parsers\Interfaces;

interface IUrlParser
{
    /**
     * Receives block content by the given selector
     *
     * @return string
     */
    function getUrlContentBody(): string;
}
