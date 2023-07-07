<?php

namespace App\Actions;

use App\Interfaces\ArchiveExtractorInterface;
use App\Interfaces\FolderCreatorInterface;
use App\Interfaces\HtmlToJsonInterface;
use App\Interfaces\XhtmlToJsonInterface;

class HtmlToJsonFormatter implements HtmlToJsonInterface
{

    private FolderCreatorInterface $folderCreator;
    private ArchiveExtractorInterface $archiveExtractor;
    private XhtmlToJsonInterface $xhtmlToJsonParser;

    public function __construct(
        FolderCreatorInterface $folderCreator,
        ArchiveExtractorInterface $archiveExtractor,
        XhtmlToJsonInterface $xhtmlToJsonParser,
    ) {
        $this->folderCreator = $folderCreator;
        $this->archiveExtractor = $archiveExtractor;
        $this->xhtmlToJsonParser = $xhtmlToJsonParser;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        try {
            $this->folderCreator->create();
            $this->archiveExtractor->extract('task')->move('task');
            $this->xhtmlToJsonParser->parse();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return true;
        }

        return true;
    }

}