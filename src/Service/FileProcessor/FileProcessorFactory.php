<?php

namespace App\Service\FileProcessor;


use App\Exception\UnsupportedFileException;


class FileProcessorFactory
{
    private  $xmlContentProcessor;

    /**
     * ContentProcessorFactory constructor.
     * @param \App\Service\FileProcessor\XMLFileProcessor $XMLContentProcessor
     */
    public function __construct(XMLFileProcessor $XMLContentProcessor)
    {
        $this->xmlContentProcessor = $XMLContentProcessor;
    }

    /**
     * @param string $type
     * @return \App\Service\FileProcessor\FileProcessorInterface
     * @throws UnsupportedFileException
     */
    public function build(string $type): FileProcessorInterface
    {
        switch ($type){
            case 'xml':
                return $this->xmlContentProcessor;
            default:
                throw new UnsupportedFileException();
        }
    }
}