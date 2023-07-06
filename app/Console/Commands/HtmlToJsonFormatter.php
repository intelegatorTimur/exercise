<?php

namespace App\Console\Commands;

use App\Services\ArchiveExtractorService;
use App\Services\FolderCreatorService;
use App\Services\XhtmlToJsonParser;
use Illuminate\Console\Command;

class HtmlToJsonFormatter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Html to Json Formatter';

    /**
     * Execute the console command.
     */


    public function handle(): bool
    {
        $folder = new FolderCreatorService();
        $archive = new ArchiveExtractorService();
        $xmlToJson = new XhtmlToJsonParser();

        $formatter = new \App\Actions\HtmlToJsonFormatter($folder, $archive, $xmlToJson);
        $formatter->handle();
        return true;
    }
}
