<?php
/**
 * Created by PhpStorm.
 * User: morayobamgbose
 * Date: 01/08/2021
 * Time: 10:12 PM
 */

namespace App\Service\ContentWriter;

use App\Service\FileProcessor\FileContent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class ContentMessengerHandler implements MessageHandlerInterface
{
    /**
     * @var ContentWriterFactory
     */
    private $contentWriterFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ContentWriterFactory $contentWriterFactory, LoggerInterface $logger)
    {
        $this->contentWriterFactory = $contentWriterFactory;
        $this->logger = $logger;
    }

    /**
     * @param FileContent $content
     */
    public function __invoke(FileContent $content)
    {
        $contentWriter = $this->contentWriterFactory->build(ContentWriterInterface::GOOGLE_XML_WRITER);
        $contentWriter->write($content);
    }

}