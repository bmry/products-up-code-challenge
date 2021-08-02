<?php


namespace App\Command;

use App\Service\ContentProcessor\ContentProcessorFactory;
use App\Exception\ProductsUpException;
use App\Utility\FileUtil;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ContentProcessorCommand extends Command
{
    /**
     * @var ContentProcessorFactory
     */
    private $contentProcessorFactory;
    /**
     * @var string
     */
    private $dataSource;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ContentProcessorFactory $contentProcessorFactory,
        string  $dataSource,
        LoggerInterface $logger
    )
    {
        $this->contentProcessorFactory = $contentProcessorFactory;
        $this->dataSource = $dataSource;
        $this->logger = $logger;

        parent::__construct();
    }

    protected static $defaultName = 'content-processor:start';

    protected function configure(): void
    {
        $this
            ->setDescription('Process File Content');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \App\Exception\UnsupportedFileException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileType = FileUtil::getFileType($this->dataSource);

        try{
            $contentProcessor = $this->contentProcessorFactory->build($fileType);
            $contentProcessor->process();
        }catch (ProductsUpException $productsUpException) {

            $this->logger->error($productsUpException);
            return Command::FAILURE;
        }

        return Command::SUCCESS;

    }


}