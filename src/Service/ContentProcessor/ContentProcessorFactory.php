<?php

namespace App\Service\ContentProcessor;


use App\Exception\UnsupportedFileException;


class ContentProcessorFactory
{
    private  $xmlContentProcessor;

    /**
     * ContentProcessorFactory constructor.
     * @param \App\Service\ContentProcessor\XMLContentProcessor $XMLContentProcessor
     */
    public function __construct(XMLContentProcessor $XMLContentProcessor)
    {
        $this->xmlContentProcessor = $XMLContentProcessor;
    }

    /**
     * @param string $type
     * @return \App\Service\ContentProcessor\ContentProcessorInterface
     * @throws UnsupportedFileException
     */
    public function build(string $type): ContentProcessorInterface
    {
        switch ($type){
            case 'xml':
                return $this->xmlContentProcessor;
            default:
                throw new UnsupportedFileException();
        }
    }
}