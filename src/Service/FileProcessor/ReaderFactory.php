<?php


namespace App\Service\FileProcessor;


class ReaderFactory
{
    public function build(string $type)
    {
        switch ($type){
            case 'xml':
                return new \XMLReader();
            default:
        }
    }
}