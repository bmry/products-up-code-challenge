<?php


namespace App\Command;

use App\Service\FileProcessor\FileProcessorFactory;
use App\Exception\ProductsUpException;
use App\Utility\FileUtil;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class FileProcessorCommand extends Command
{
    /**
     * @var FileProcessorFactory
     */
    private $contentProcessorFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        FileProcessorFactory $contentProcessorFactory,
        LoggerInterface $logger
    )
    {
        $this->contentProcessorFactory = $contentProcessorFactory;
        $this->logger = $logger;

        parent::__construct();
    }

    protected static $defaultName = 'file-processor:start';

    protected function configure(): void
    {
        $this
            ->setDescription('Process File Content and Push to GoogleSheet')
            ->addArgument(
                'path-to-file',
                InputArgument::REQUIRED,
                'Path to file'
            )
            ->addOption(
                'file-path',
                'f',
                InputOption::VALUE_REQUIRED,
                'Please provide file location'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \App\Exception\UnsupportedFileException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('path-to-file');
        $fileType = FileUtil::getFileType($filePath);

        try{
            $contentProcessor = $this->contentProcessorFactory->build($fileType);
            $contentProcessor->process($filePath);
        }catch (ProductsUpException $productsUpException) {

            $this->logger->error($productsUpException);
            return Command::FAILURE;
        }

        return Command::SUCCESS;

    }


}