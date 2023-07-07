<?php

namespace App\Services;

use App\Interfaces\XhtmlToJsonInterface;

class XhtmlToJsonParser implements XhtmlToJsonInterface
{
    private const PARSE = 'parse.json';

    public string $dataXhtml;
    public array $data;
    public \DOMDocument $dom;
    public array $textParse = ['span', 'p', 'div', 'em'];

    public function __construct()
    {
        $this->dom = new \DOMDocument();
    }

    /**
     * @return true
     */
    public function parse(): bool
    {
        $this->readXtmlFile()
            ->writeTextToJson()
            ->writeImageToJson()
            ->writeCssToJson()
            ->createJson();

        return true;
    }

    /**
     * @return $this
     */
    public function createJson(): XhtmlToJsonParser
    {
        if (!\File::exists(storage_path() . '/' . self::PARSE)) {
            $json = json_encode($this->data);
            \File::put(storage_path() . '/' . self::PARSE, $json);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function readXtmlFile(): XhtmlToJsonParser
    {
        $dataXhtml = file_get_contents(
            storage_path() . '/' . FolderCreatorService::PROJECT_NAME . '/' . ArchiveExtractorService::FILE_CHAPTER_NAME
        );
        $this->dataXhtml = $dataXhtml;
        return $this;
    }

    /**
     * @return XhtmlToJsonParser
     */
    public function writeTextToJson(): XhtmlToJsonParser
    {
        foreach ($this->textParse as $item) {
            $tags = $this->getTags($item);
            foreach ($tags as $child) {
                if (strlen($child->nodeValue) <= 3000) {
                    $this->data['blocks'][] = [
                        'blockId' => \Str::uuid()->toString(),
                        'html'    => $child->nodeValue
                    ];
                }
            }
        }


        return $this;
    }

    /**
     * @return $this
     */
    public function writeImageToJson(): XhtmlToJsonParser
    {
        $tags = $this->getTags('img');

        foreach ($tags as $child) {
            $this->data['images'][] = [
                'imageId' => \Str::uuid()->toString(),
                'path'    => storage_path() . '/' . FolderCreatorService::PROJECT_NAME . '/' . $child->getAttribute(
                        'src'
                    ),
                'caption' => $child->getAttribute('alt')
            ];
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function writeCssToJson(): XhtmlToJsonParser
    {
        $tags = $this->getTags('table');
        foreach ($tags as $child) {
            $content = $this->dom->saveHTML($child);

            $this->data['tables'][] = [
                'tableId' => \Str::uuid()->toString(),
                'html'    => $content,
                'caption' => $child->getAttribute('alt')
            ];
        }

        return $this;
    }

    /**
     * @param string $tag
     * @return \DOMNodeList
     */
    public function getTags(string $tag): \DOMNodeList
    {
        $this->dom->loadXML($this->dataXhtml);
        return $this->dom->getElementsByTagName($tag);
    }


}