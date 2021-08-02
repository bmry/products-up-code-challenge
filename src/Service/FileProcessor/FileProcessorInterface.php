<?php

namespace App\Service\FileProcessor;


interface FileProcessorInterface
{
    public function process(string $filePath): void;
}