<?php


namespace Hj;

use Hj\Exception\UndefinedColumnException;
use Hj\File\HostFile;
use Hj\File\ReceiverFile;
use Monolog\Logger;

/**
 * Created by jacquirhatim@gmail.com
 *
 * Class HeaderValidator
 * @package Hj
 */
class ConfigHeaderValidator
{
    /**
     * @var ReceiverFile
     */
    private $receiverFile;

    /**
     * @var HostFile
     */
    private $hostFile;

    /**
     * @var YamlConfigLoader
     */
    private $configLoader;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * HeaderValidator constructor.
     * @param ReceiverFile $receiverFile
     * @param HostFile $hostFile
     * @param YamlConfigLoader $configLoader
     * @param Logger $logger
     */
    public function __construct(ReceiverFile $receiverFile, HostFile $hostFile, YamlConfigLoader $configLoader, Logger $logger)
    {
        $this->receiverFile = $receiverFile;
        $this->hostFile = $hostFile;
        $this->configLoader = $configLoader;
        $this->logger = $logger;
    }


    /**
     * @param string $headerName
     * @param array $headers
     *
     * @throws UndefinedColumnException
     */
    private function ckeckHeader(string $headerName, array $headers) {
        if (!in_array($headerName, $headers)) {
            /** @var string $message */
            $message = "The header : {$headerName}, does not exist. Please check your csv file or your config yaml file.";
            $this->logger->error($message);
            throw new UndefinedColumnException($message);
        }
    }

    /**
     * @throws UndefinedColumnException
     */
    public function valid()
    {
        $this->logger->info("Header validation started ...");
        $hostFileHeaders = $this->hostFile->getHeaderAsArray();
        $receiverFileHeaders = $this->receiverFile->getHeaderAsArray();

        foreach ($this->configLoader->getKeyHeader() as $key => $value) {
            $this->ckeckHeader($value['receiver'], $receiverFileHeaders);
            $this->ckeckHeader($value['host'], $hostFileHeaders);
        }

        foreach ($this->configLoader->getMappingMigration() as $host => $receiver) {
            $this->ckeckHeader($receiver, $receiverFileHeaders);
            $this->ckeckHeader($host, $hostFileHeaders);
        }
        $this->logger->info("Header validation done. All header are OK ...");
    }
}