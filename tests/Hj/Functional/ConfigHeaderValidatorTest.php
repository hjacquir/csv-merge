<?php


namespace Hj\Tests\Functional;


use Hj\ConfigHeaderValidator;
use Hj\File\HostFile;
use Hj\File\ReceiverFile;
use Hj\Validator\YamlFile\KeyValueValidator\ConfigFileValidator;
use Hj\YamlConfigLoader;
use Monolog\Logger;
use ParseCsv\Csv;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigHeaderValidatorTest
 * @package Hj\Tests\Functional
 */
class ConfigHeaderValidatorTest extends TestCase
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
     * @var string
     */
    private $configFilePath;

    /**
     * @var Logger
     */
    private $logger;

    public function setUp()
    {
        $csvFilePath = __DIR__ . '/csvFiles/';
        $this->configFilePath = __DIR__ . '/configFiles/';

        $this->receiverFile = new ReceiverFile($csvFilePath . 'receiver.csv', new Csv());
        $this->hostFile = new HostFile($csvFilePath . 'host.csv', new Csv());
        $this->logger = new Logger('test');

    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : bla, does not exist.
     */
    public function testValidThrowExceptionWhenReceiverKeyHeaderDoesNotExist()
    {
        $validator = $this->buildValidator($this->configFilePath . 'config_receiverKeyHeaderNotExist.yaml');
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : FOO, does not exist.
     */
    public function testValidThrowExceptionWhenHostKeyHeaderDoesNotExist()
    {
        $validator = $this->buildValidator($this->configFilePath . 'config_hostKeyHeaderNotExist.yaml');
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : Bla-foo, does not exist.
     */
    public function testValidThrowExceptionWhenReceiverMigrationMappingHeaderDoesNotExist()
    {
        $validator = $this->buildValidator($this->configFilePath . 'config_receiverMigrationMappingHeaderNotExist.yaml');
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : Hello, does not exist.
     */
    public function testValidThrowExceptionWhenHostMigrationMappingHeaderDoesNotExist()
    {
        $validator = $this->buildValidator($this->configFilePath . 'config_hostMigrationMappingHeaderNotExist.yaml');
        $validator->valid();
    }

    /**
     * @param $yamlFilePath
     * @return ConfigHeaderValidator
     */
    private function buildValidator($yamlFilePath)
    {
        $loader = new YamlConfigLoader(
            $yamlFilePath,
            new ConfigFileValidator()
        );

        $validator = new ConfigHeaderValidator(
            $this->receiverFile,
            $this->hostFile,
            $loader,
            $this->logger
        );

        return $validator;
    }
}