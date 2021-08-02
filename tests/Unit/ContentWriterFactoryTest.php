<?php

namespace App\Unit\Tests;

use App\Service\ContentWriter\ContentWriterFactory;
use App\Service\ContentWriter\ContentWriterInterface;
use App\Service\ContentWriter\GoogleSheetXMLWriter;
use PHPUnit\Framework\TestCase;

class ContentWriterFactoryTest extends TestCase
{
    protected $googleSheetXMLWriter;

    public function setUp(): void
    {
        $this->googleSheetXMLWriter = $this->createMock(GoogleSheetXMLWriter::class);

    }

    public function test_That_Instance_Of_GoogleSheet_Is_Returned_If_Type_Is_XML()
    {
        $contentWriterFactory  = new ContentWriterFactory($this->googleSheetXMLWriter);
        $contentWriter = $contentWriterFactory->build(ContentWriterInterface::GOOGLE_XML_WRITER);
        $this->assertInstanceOf(ContentWriterInterface::class, $contentWriter);
    }
}