<?php

namespace App\Service\ContentWriter;


use App\Service\FileProcessor\FileContent;

interface ContentWriterInterface
{
    const GOOGLE_XML_WRITER = 'google-xml';

    public function write(FileContent $content): void;
}