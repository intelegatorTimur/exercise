<?php

namespace App\Providers;

use App\Actions\HtmlToJsonFormatter;
use App\Interfaces\ArchiveExtractorInterface;
use App\Interfaces\FolderCreatorInterface;
use App\Interfaces\HtmlToJsonInterface;
use App\Interfaces\XhtmlToJsonInterface;
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

        $this->app->bind(ArchiveExtractorInterface::class, ArchiveExtractorService::class);
        $this->app->bind(FolderCreatorInterface::class, FolderCreatorService::class);
        $this->app->bind(XhtmlToJsonInterface::class, XhtmlToJsonParser::class);
        $this->app->bind(HtmlToJsonInterface::class, HtmlToJsonFormatter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
