<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\This;
use VIPSoft\Unzip\Unzip;
use ZanySoft\Zip\Zip;

class ArchiveExtractorService
{
    /**
     * @param string $name
     * @return $this
     */
    public function extract(string $name)
    {
        $path = storage_path($name . '.zip');
        $zip = new \ZipArchive();

        if ($zip->open($path)) {
            if (!\Storage::exists(storage_path() . '/temp/' . $name)) {
                $zip->extractTo(storage_path() . '/temp/' . $name);
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
        $this->moveXhtml($name)->moveImages($name)->moveCss($name)->deleteArchiveTempFiles($name);
        return true;
    }

    /**
     * @param string $name
     * @return $this
     */
    private function moveXhtml(string $name)
    {
        \File::move(
            storage_path() . '/temp/' . $name . '/test/PHP_backend/Chapter_1.xhtml',
            storage_path() . '/' . FolderCreatorService::PROJECT_NAME . '/Chapter_1.xhtml'
        );

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    private function moveImages(string $name)
    {
        $fileFromImages = \File::files(storage_path() . '/temp/' . $name . '/test/PHP_backend/images/Chapter_1');
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
    private function moveCss(string $name)
    {
        $fileFromImages = \File::files(storage_path() . '/temp/' . $name . '/test/PHP_backend/css');
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
    private function deleteArchiveTempFiles(string $name)
    {
        \File::deleteDirectory(storage_path() . '/temp/' . $name);
        return $this;
    }

}