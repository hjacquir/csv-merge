<?php

namespace Hj;

use Hj\File\HostFile;
use Hj\File\MergedFile;
use Hj\File\ReceiverFile;
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
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $yamlConfigFilePath = $input->getArgument('yamlConfigFilePath');
        $configLoader = new YamlConfigLoader($yamlConfigFilePath);
        $receiverFile = new ReceiverFile($configLoader->getReceiverFilePath(), new Csv());
        $hostFile = new HostFile($configLoader->getHostFilePath(), new Csv());
        $mergedFile = new MergedFile($configLoader->getMergedFilePath(), new Csv());
    }
}