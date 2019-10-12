<?php


namespace Hj\Tests\Functional;


use Hj\ConfigHeaderValidator;
use Hj\File\HostFile;
use Hj\File\ReceiverFile;
use Hj\YamlConfigLoader;
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

    public function setUp()
    {
        $csvFilePath = __DIR__ . '/csvFiles/';
        $this->configFilePath = __DIR__ . '/configFiles/';

        $this->receiverFile = new ReceiverFile($csvFilePath . 'receiver.csv', new Csv());
        $this->hostFile = new HostFile($csvFilePath . 'host.csv', new Csv());

    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : bla, does not exist.
     */
    public function testValidThrowExceptionWhenReceiverKeyHeaderDoesNotExist()
    {

        $configLoader = new YamlConfigLoader($this->configFilePath . 'config_receiverKeyHeaderNotExist.yaml');

        $validator = new ConfigHeaderValidator($this->receiverFile, $this->hostFile, $configLoader);
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : FOO, does not exist.
     */
    public function testValidThrowExceptionWhenHostKeyHeaderDoesNotExist()
    {

        $configLoader = new YamlConfigLoader($this->configFilePath . 'config_hostKeyHeaderNotExist.yaml');

        $validator = new ConfigHeaderValidator($this->receiverFile, $this->hostFile, $configLoader);
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : Bla-foo, does not exist.
     */
    public function testValidThrowExceptionWhenReceiverMigrationMappingHeaderDoesNotExist()
    {

        $configLoader = new YamlConfigLoader($this->configFilePath . 'config_receiverMigrationMappingHeaderNotExist.yaml');

        $validator = new ConfigHeaderValidator($this->receiverFile, $this->hostFile, $configLoader);
        $validator->valid();
    }

    /**
     * @expectedException \Hj\Exception\UndefinedColumnException
     * @expectedExceptionMessage The header : Hello, does not exist.
     */
    public function testValidThrowExceptionWhenHostMigrationMappingHeaderDoesNotExist()
    {

        $configLoader = new YamlConfigLoader($this->configFilePath . 'config_hostMigrationMappingHeaderNotExist.yaml');

        $validator = new ConfigHeaderValidator($this->receiverFile, $this->hostFile, $configLoader);
        $validator->valid();
    }
}