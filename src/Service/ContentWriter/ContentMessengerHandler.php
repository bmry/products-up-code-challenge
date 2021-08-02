<?php
/**
 * Created by PhpStorm.
 * User: morayobamgbose
 * Date: 01/08/2021
 * Time: 10:12 PM
 */

namespace App\Service\ContentWriter;


use App\Exception\ProductsUpException;
use App\Service\ContentProcessor\Content;
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
     * @param Content $content
     */
    public function __invoke(Content $content)
    {
        try{
            $contentWriter = $this->contentWriterFactory->build(ContentWriterInterface::GOOGLE_XML_WRITER);
            $contentWriter->write($content);

        }catch (ProductsUpException $productsUpException){
            $this->logger->error($productsUpException);
        }

    }

}