<?php

namespace App\Actions;

use App\Services\ArchiveExtractorService;
use App\Services\FolderCreatorService;
use App\Services\XhtmlToJsonParser;

class HtmlToJsonFormatter
{

    private FolderCreatorService $folderCreator;
    private ArchiveExtractorService $archiveExtractor;
    private XhtmlToJsonParser $xhtmlToJsonParser;

    public function __construct(
        FolderCreatorService $folderCreator,
        ArchiveExtractorService $archiveExtractor,
        XhtmlToJsonParser $xhtmlToJsonParser,
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
            echo $exception->getMessage('Oops, something goes wrong!');
        }

        return true;
    }

}