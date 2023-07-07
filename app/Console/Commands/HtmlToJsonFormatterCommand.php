<?php

namespace App\Console\Commands;

use App\Interfaces\HtmlToJsonInterface;
use App\Services\ArchiveExtractorService;
use App\Actions\HtmlToJsonFormatter;
use App\Services\FolderCreatorService;
use App\Services\XhtmlToJsonParser;
use Illuminate\Console\Command;

class HtmlToJsonFormatterCommand extends Command
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


    public function handle(HtmlToJsonInterface $htmlToJsonProvider): bool
    {
        echo ($htmlToJsonProvider->handle()) ? "Success!" : "Not work!";

        return true;
    }
}
