<?php

namespace Hj;

use Hj\Validator\Validator;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader
{
    const KEY_FILE_PATH = 'filePath';
    const KEY_RECEIVER = 'receiver';
    const KEY_HOST = 'host';
    const KEY_MERGED = 'merged';
    const KEY_KEYHEADER = 'keyHeader';
    const KEY_MIGRATION_MAPPING = 'migrationMapping';
    const KEY_MAPPING_RELATION = 'mappingRelation';

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
     * @var string
     */
    private $mappingRelation;

    /**
     * @param string $yamlFile
     * @param Validator $validator
     */
    public function __construct(string $yamlFile, Validator $validator)
    {
        $this->yamlFile = $yamlFile;
        $this->parsedValues = Yaml::parseFile($this->yamlFile);
        $validator->valid($this->parsedValues, $this->yamlFile);
    }

    /**
     * @return string
     */
    public function getMappingRelation(): string
    {
        $this->receiverFilePath = $this->parsedValues[self::KEY_MAPPING_RELATION];
        return $this->mappingRelation;
    }

    /**
     * @return string
     */
    public function getReceiverFilePath() : string
    {
        $this->receiverFilePath = $this->parsedValues[self::KEY_FILE_PATH][self::KEY_RECEIVER];
        return $this->receiverFilePath;
    }

    /**
     * @return string
     */
    public function getHostFilePath() : string
    {
        $this->hostFilePath = $this->parsedValues[self::KEY_FILE_PATH][self::KEY_HOST];
        return $this->hostFilePath;
    }

    /**
     * @return string
     */
    public function getMergedFilePath() : string
    {
        $this->mergedFilePath = $this->parsedValues[self::KEY_FILE_PATH][self::KEY_MERGED];
        return $this->mergedFilePath;
    }

    /**
     * @return array
     */
    public function getKeyHeader() : array
    {
        $this->keyHeader = $this->parsedValues[self::KEY_KEYHEADER];
        return $this->keyHeader;
    }

    /**
     * @return array
     */
    public function getMappingMigration() : array
    {
        $this->mappingMigration = $this->parsedValues[self::KEY_MIGRATION_MAPPING];
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