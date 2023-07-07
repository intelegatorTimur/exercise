<?php

namespace App\Services;

use App\Interfaces\ArchiveExtractorInterface;

class ArchiveExtractorService implements ArchiveExtractorInterface
{
    public const FILE_CHAPTER_NAME = 'Chapter_1.xhtml';
    public const TEMP_DIRECTORY = 'temp';
    public const PHP_BACKEND_DIRECTORY = '/test/PHP_backend/';
    public const CHAPTER_DIRECTORY = 'images/Chapter_1';
    public const CSS_DIRECTORY = 'css';

    /**
     * @param string $name
     * @return $this
     */
    public function extract(string $name): ArchiveExtractorService
    {
        $path = storage_path($name . '.zip');
        $zip = new \ZipArchive();

        if ($zip->open($path)) {
            if (!\Storage::exists(storage_path() . '/' . self::TEMP_DIRECTORY . '/' . $name)) {
                $zip->extractTo(storage_path() . '/' . self::TEMP_DIRECTORY . '/' . $name);
            }
        }

        $zip->close();
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function move(string $name): bool
    {
        $this->moveXhtml($name)
            ->moveImages($name)
            ->moveCss($name)
            ->deleteArchiveTempFiles($name);

        return true;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function moveXhtml(string $name): ArchiveExtractorService
    {
        \File::move(
            storage_path(
            ) . '/' . self::TEMP_DIRECTORY . '/' . $name . self::PHP_BACKEND_DIRECTORY . self::FILE_CHAPTER_NAME,
            storage_path() . '/' . FolderCreatorService::PROJECT_NAME . '/' . self::FILE_CHAPTER_NAME
        );

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function moveImages(string $name): ArchiveExtractorService
    {
        $fileFromImages = \File::files(
            storage_path(
            ) . '/' . self::TEMP_DIRECTORY . '/' . $name . self::PHP_BACKEND_DIRECTORY . self::CHAPTER_DIRECTORY

        );
        foreach ($fileFromImages as $fileFromImage) {
            \File::move(
                $fileFromImage->getPathname(),
                storage_path(
                ) . '/' . FolderCreatorService::PROJECT_NAME . '/' . FolderCreatorService::IMAGES . '/' . $fileFromImage->getFilename(
                )
            );
        }


        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function moveCss(string $name): ArchiveExtractorService
    {
        $fileFromImages = \File::files(
            storage_path(
            ) . '/' . self::TEMP_DIRECTORY . '/' . $name . self::PHP_BACKEND_DIRECTORY . self::CSS_DIRECTORY
        );
        foreach ($fileFromImages as $fileFromImage) {
            \File::move(
                $fileFromImage->getPathname(),
                storage_path(
                ) . '/' . FolderCreatorService::PROJECT_NAME . '/' . FolderCreatorService::STYLE_IMAGES . '/' . $fileFromImage->getFilename(
                )
            );
        }


        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function deleteArchiveTempFiles(string $name): ArchiveExtractorService
    {
        \File::deleteDirectory(storage_path() . '/' . self::TEMP_DIRECTORY . '/' . $name);
        return $this;
    }

}