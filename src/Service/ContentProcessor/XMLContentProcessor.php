<?php


namespace App\Service\ContentProcessor;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class XMLContentProcessor
 * @package App\Service\ContentProvider
 */
class XMLContentProcessor implements ContentProcessorInterface
{
    private $dataSource;

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
        MessageBusInterface $messageBus,
        string $dataSource)
    {
        $this->dataSource = $dataSource;
        $this->logger = $logger;
        $this->messageBus = $messageBus;

    }

    public function process(): void
    {
        $xmlReader = new \XMLReader();

        if ($xmlReader->open($this->dataSource)) {

            while ($xmlReader->read() && $xmlReader->name !== 'catalog');

            while ($xmlReader->name === 'catalog') {

                try{
                    $element = new \SimpleXMLElement($xmlReader->readOuterXML());
                    $items = $element->item;

                    foreach ($items as $item) {
                        $this->messageBus->dispatch(new Content(json_encode($item)));
                    }

                }catch (\Exception $exception) {
                    $this->logger->error($exception);
                }


            }
        }
    }

}