<?php

namespace Hj\Tests\Unit;

use Hj\Validator\YamlFile\KeyValueValidator\ConfigFileValidator;
use Hj\YamlConfigLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class YamlConfigLoaderTest extends TestCase
{
    /**
     * @var YamlConfigLoader
     */
    private $loader;

    /**
     * @var ConfigFileValidator | MockObject
     */
    private $configFileValidator;

    protected function setUp()
    {
        $this->configFileValidator = parent::getMockBuilder(ConfigFileValidator::class)->getMock();

        $this->loader = new YamlConfigLoader(__DIR__ . '/config.yaml', $this->configFileValidator);
    }

    public function testGetReceiverFilePath()
    {
        parent::assertSame('testFilePath/receiver.csv', $this->loader->getReceiverFilePath());
    }

    public function testGetHostFilePath()
    {
        parent::assertSame('testFilePath/host.csv', $this->loader->getHostFilePath());
    }

    public function testGetMergedFilePath()
    {
        parent::assertSame('testFilePath/merged.csv', $this->loader->getMergedFilePath());
    }

    public function testGetKeyHeader()
    {
        parent::assertSame([
            0 => [
                'receiver' => 'keyHeaderReceiver',
                'host' => 'keyHeaderHost',
            ],
            1 => [
                'receiver' => 'keyHeaderReceiver2',
                'host' => 'keyHeaderHost2',
            ],
        ],
            $this->loader->getKeyHeader());
    }

    public function testGetMappingMigration()
    {
        parent::assertSame([
            'headerHost1' => 'headerReceiver1',
            'headerHost2' => 'headerReceiver2',
        ],
            $this->loader->getMappingMigration());
    }

}