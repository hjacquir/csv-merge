<?php


namespace Hj;

use Hj\Exception\UndefinedColumnException;
use Hj\File\HostFile;
use Hj\File\ReceiverFile;

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
     * HeaderValidator constructor.
     * @param ReceiverFile $receiverFile
     * @param HostFile $hostFile
     * @param YamlConfigLoader $configLoader
     */
    public function __construct(ReceiverFile $receiverFile, HostFile $hostFile, YamlConfigLoader $configLoader)
    {
        $this->receiverFile = $receiverFile;
        $this->hostFile = $hostFile;
        $this->configLoader = $configLoader;
    }


    /**
     * @param string $headerName
     * @param array $headers
     *
     * @throws UndefinedColumnException
     */
    private function ckeckHeader(string $headerName, array $headers) {
        if (!in_array($headerName, $headers)) {
            throw new UndefinedColumnException("The header : {$headerName}, does not exist. Please check your csv file or your config yaml file.");
        }
    }

    /**
     * @throws UndefinedColumnException
     */
    public function valid()
    {
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
    }
}