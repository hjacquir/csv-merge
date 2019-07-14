<?php

namespace Hj;

use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader
{
    /**
     * @var string
     */
    private $receiverFilePath;
    /**
     * @var string
     */
    private $hostFilePath;
    /**
     * @var string
     */
    private $mergedFilePath;
    /**
     * @var array
     */
    private $keyHeader;
    /**
     * @var array
     */
    private $mappingMigration;

    /**
     * @var string
     */
    private $yamlFile;

    /**
     * @var array
     */
    private $parsedValues;

    /**
     * @param string $yamlFile
     */
    public function __construct(string $yamlFile)
    {
        $this->yamlFile = $yamlFile;
        $this->parsedValues = Yaml::parseFile($this->yamlFile);
    }

    /**
     * @return string
     */
    public function getReceiverFilePath() : string
    {
        $this->receiverFilePath = $this->parsedValues['filePath']['receiver'];
        return $this->receiverFilePath;
    }

    /**
     * @return string
     */
    public function getHostFilePath() : string
    {
        $this->hostFilePath = $this->parsedValues['filePath']['host'];
        return $this->hostFilePath;
    }

    /**
     * @return string
     */
    public function getMergedFilePath() : string
    {
        $this->mergedFilePath = $this->parsedValues['filePath']['merged'];
        return $this->mergedFilePath;
    }

    /**
     * @return array
     */
    public function getKeyHeader() : array
    {
        $this->keyHeader = $this->parsedValues['keyHeader'];
        return $this->keyHeader;
    }

    /**
     * @return array
     */
    public function getMappingMigration() : array
    {
        $this->mappingMigration = $this->parsedValues['migrationMapping'];
        return $this->mappingMigration;
    }

    /**
     * @return string
     */
    public function getYamlFile() : string
    {
        return $this->yamlFile;
    }

    /**
     * @return array
     */
    public function getParsedValues() : array
    {
        return $this->parsedValues;
    }
}