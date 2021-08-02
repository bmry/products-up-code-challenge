<?php


namespace App\Service\FileProcessor;

use App\Exception\UnreadableFileException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class XMLContentProcessor
 * @package App\Service\ContentProvider
 */
class XMLFileProcessor implements FileProcessorInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var MessageBusInterface
     */
    private $messageBus;


    /**
     * XMLContentProcessor constructor.
     * @param LoggerInterface $logger
     * @param MessageBusInterface $messageBus
     * @param string $dataSource
     */
    public function __construct(
        LoggerInterface $logger,
        MessageBusInterface $messageBus)
    {
        $this->logger = $logger;
        $this->messageBus = $messageBus;

    }

    public function process(string $filePath): void
    {
        $xmlReader = new \XMLReader();
        $xmlContent =  $xmlReader->open($filePath);

        if(false === $xmlContent){
            throw new UnreadableFileException("Unable to read file");
        }

        while ($xmlReader->read() && $xmlReader->name !== 'catalog');

        while ($xmlReader->name === 'catalog') {

            try{
                $element = new \SimpleXMLElement($xmlReader->readOuterXML());
                $items = $element->item;

                foreach ($items as $item) {
                    $this->messageBus->dispatch(new FileContent(json_encode($item)));
                }

            }catch (\Exception $exception) {
                $this->logger->error($exception);
            }


        }
    }

}