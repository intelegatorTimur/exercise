<?php

namespace App\Interfaces;

use App\Services\XhtmlToJsonParser;

interface XhtmlToJsonInterface
{
    /**
     * @return bool
     */
    public function parse(): bool;

    /**
     * @return XhtmlToJsonParser
     */
    public function createJson(): XhtmlToJsonParser;

    /**
     * @return XhtmlToJsonParser
     */
    public function readXtmlFile(): XhtmlToJsonParser;

    /**
     * @return XhtmlToJsonParser
     */
    public function writeTextToJson(): XhtmlToJsonParser;

    public function writeImageToJson(): XhtmlToJsonParser;

    /**
     * @return XhtmlToJsonParser
     */
    public function writeCssToJson(): XhtmlToJsonParser;

    /**
     * @param string $tag
     * @return \DOMNodeList
     */
    public function getTags(string $tag): \DOMNodeList;
}