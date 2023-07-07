<?php

namespace App\Interfaces;

interface FolderCreatorInterface
{
    /**
     * @return bool
     */
    public function create(): bool;
}