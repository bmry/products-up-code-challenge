<?php


namespace App\Unit\Tests;


use App\Service\FileProcessor\ReaderFactory;
use App\Service\FileProcessor\XMLFileProcessor;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class XMLFileProcessorTest extends TestCase
{
    protected $messengerBus;
    protected $logger;
    protected $xmlReader;
    protected $readerFactory;



    public function setUp(): void
    {
        $this->messengerBus = $this->getMockBuilder(MessageBusInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['dispatch'])
            ->getMock();

        $this->xmlReader = $this->getMockBuilder(\XMLReader::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['open','readOuterXML', 'read', 'next'])
            ->getMock();

        $this->readerFactory = $this->getMockBuilder(ReaderFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function test_That_Error_Message_Unable_To_Read_File_Is_Thrown_If_File_Is_Invalid()
    {

        $this->xmlReader->expects($this->any())
            ->method('open')
            ->willReturn(false);

        $this->readerFactory->expects($this->once())
            ->method('build')
            ->willReturn($this->xmlReader);

        $this->expectExceptionMessage('Unable to read file');

        $XMLFileProcessor = new XMLFileProcessor($this->logger, $this->messengerBus, $this->readerFactory);
        $XMLFileProcessor->process('fake.xml');
    }

    public function test_That_Valid_Content_Are_Dispatched()
    {


    }



}