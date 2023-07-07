<?php

namespace App\Interfaces;

use App\Services\ArchiveExtractorService;

interface ArchiveExtractorInterface
{
    /**
     * @param string $name
     * @return ArchiveExtractorService
     */
    public function extract(string $name): ArchiveExtractorService;

    /**
     * @param string $name
     * @return bool
     */
    public function move(string $name): bool;

    /**
     * @param string $name
     * @return ArchiveExtractorService
     */
    public function moveXhtml(string $name): ArchiveExtractorService;

    /**
     * @param string $name
     * @return ArchiveExtractorService
     */
    public function moveImages(string $name): ArchiveExtractorService;

    /**
     * @param string $name
     * @return ArchiveExtractorService
     */
    public function moveCss(string $name): ArchiveExtractorService;

    /**
     * @param string $name
     * @return ArchiveExtractorService
     */
    public function deleteArchiveTempFiles(string $name): ArchiveExtractorService;

}