<?php

namespace App\Service\ContentWriter;


use App\Service\ContentProcessor\Content;

interface ContentWriterInterface
{
    const GOOGLE_XML_WRITER = 'google-xml';

    public function write(Content $content): void;
}