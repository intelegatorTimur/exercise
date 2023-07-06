<?php

namespace App\Providers;

use App\Actions\HtmlToJsonFormatter;
use App\Services\ArchiveExtractorService;
use App\Services\FolderCreatorService;
use App\Services\XhtmlToJsonParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(HtmlToJsonFormatter::class, function () {
            $folder = new FolderCreatorService();
            $archive = new ArchiveExtractorService();
            $xmlToJson = new XhtmlToJsonParser();

            return new HtmlToJsonFormatter($folder, $archive, $xmlToJson);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
