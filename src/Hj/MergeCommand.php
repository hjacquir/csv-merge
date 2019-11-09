<?php

namespace Hj;

use Hj\File\HostFile;
use Hj\File\MergedFile;
use Hj\File\ReceiverFile;
use Hj\Validator\YamlFile\KeyValueValidator\ConfigFileValidator;
use Monolog\Logger;
use ParseCsv\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MergeCommand extends Command
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }


    protected function configure()
    {
        $this->setName('file:merge');
        $this
            ->addArgument(
                'yamlConfigFilePath',
                InputArgument::REQUIRED,
                'The path to the yaml config file'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws Exception\FileNotFoundException
     * @throws Exception\UndefinedColumnException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info("Operation started ...");
        $yamlConfigFilePath = $input->getArgument('yamlConfigFilePath');
        $configLoader = new YamlConfigLoader($yamlConfigFilePath, new ConfigFileValidator());
        $receiverFile = new ReceiverFile($configLoader->getReceiverFilePath(), new Csv());
        $hostFile = new HostFile($configLoader->getHostFilePath(), new Csv());
        $mergedFile = new MergedFile($configLoader->getMergedFilePath(), new Csv());
        $keyHeaders = $configLoader->getKeyHeader();
        $extractor = new Extractor('', '');
        foreach ($keyHeaders as $key => $keyHeader) {
            if ($key == 0) {
                $extractor = new Extractor($keyHeader['receiver'], $keyHeader['host']);
            } else {
                // add successor if exists
                $successor = new Extractor($keyHeader['receiver'], $keyHeader['host']);
                $extractor->setSuccessor($successor);
            }
        }
        $migrationMapping = $configLoader->getMappingMigration();
        $processor = new Processor();

        $configHeaderValidator = new ConfigHeaderValidator($receiverFile, $hostFile, $configLoader, $this->logger);
        $mergedFile->create($receiverFile, $hostFile, $processor, $extractor, $migrationMapping, $configHeaderValidator, $this->logger);
        $this->logger->info("Operation completed. The merged file was generated in : {$configLoader->getMergedFilePath()}");
    }
}