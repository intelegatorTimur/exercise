<?php

namespace App\Services;

class FolderCreatorService
{
    public const PROJECT_NAME = 'name_project';
    public const IMAGES = 'images';
    public const STYLE_IMAGES = 'styleImages';

    /**
     * @return bool
     */
    public function create(): bool
    {
        $this->checkExistance();
        return true;
    }

    /**
     * @return bool
     */
    private function checkExistance(): bool
    {
        $pathStorageNameProject = storage_path() . '/' . self::PROJECT_NAME;
        $pathStorageImages = storage_path() . '/' . self::PROJECT_NAME . '/' . self::IMAGES;
        $pathStorageStyleImages = storage_path() . '/' . self::PROJECT_NAME . '/' . self::STYLE_IMAGES;

        $directoryPaths = [
            $pathStorageNameProject,
            $pathStorageImages,
            $pathStorageStyleImages
        ];

        foreach ($directoryPaths as $directoryPath) {
            \File::makeDirectory($directoryPath, 0777, true, true);
        }

        return true;
    }
}