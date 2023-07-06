<?php

namespace App\Services;

use gymadarasz\xparser\XNode;

class XhtmlToJsonParser
{
    private const Parse = 'parse.json';

    public string $dataXhtml;
    public array $data;
    public \DOMDocument $dom;

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
            ->writeImageToJson()
            ->writeCssToJson()
            ->creacteJson();

        return true;
    }

    /**
     * @return $this
     */
    private function creacteJson()
    {
        if (!\File::exists(storage_path() . '/' . self::Parse)) {
            $json = json_encode($this->data);
            \File::put(storage_path() . '/' . self::Parse, $json);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function readXtmlFile()
    {
        $dataXhtml = file_get_contents(storage_path() . '/' . FolderCreatorService::PROJECT_NAME . '/Chapter_1.xhtml');
        $this->dataXhtml = $dataXhtml;
        return $this;
    }

    /**
     * @return $this
     */
    private function writeImageToJson()
    {
        $this->dom->loadXML($this->dataXhtml);
        $tags = $this->dom->getElementsByTagName('img');

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
    private function writeCssToJson()
    {
        $this->dom->loadXML($this->dataXhtml);
        $tags = $this->dom->getElementsByTagName('table');

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


}