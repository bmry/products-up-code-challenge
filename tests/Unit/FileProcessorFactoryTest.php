<?php

namespace App\Unit\Tests;


use App\Exception\UnsupportedFileException;
use App\Service\FileProcessor\FileProcessorFactory;
use App\Service\FileProcessor\FileProcessorInterface;
use App\Service\FileProcessor\XMLFileProcessor;
use PHPUnit\Framework\TestCase;

class FileProcessorFactoryTest extends TestCase
{
    protected $xmlFileProcessor;

    public function setUp(): void
    {
        $this->xmlFileProcessor = $this->createMock(XMLFileProcessor::class);

    }

    public function test_That_Instance_Of_XMLFileProcessor_Is_Returned_If_Type_Is_XML()
    {
       $fileProcessorFactory  = new FileProcessorFactory($this->xmlFileProcessor);
       $fileProcessor = $fileProcessorFactory->build('xml');
       $this->assertInstanceOf(FileProcessorInterface::class, $fileProcessor);
    }

    public function test_That_Exception_Is_Thrown_If_UnSupported_Type_Is_Passed()
    {
        $this->expectExceptionObject(new UnsupportedFileException());
        $fileProcessorFactory  = new FileProcessorFactory($this->xmlFileProcessor);
        $fileProcessorFactory->build('json');

    }

}