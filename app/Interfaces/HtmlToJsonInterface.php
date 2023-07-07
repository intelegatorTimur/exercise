<?php

namespace App\Interfaces;

interface HtmlToJsonInterface
{
    /**
     * @return bool
     */
    public function handle(): bool;
}