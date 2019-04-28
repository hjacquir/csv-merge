<?php

namespace Hj\Tests\Unit;

use Hj\YamlConfigLoader;
use PHPUnit\Framework\TestCase;

class YamlConfigLoaderTest extends TestCase
{
    /**
     * @var YamlConfigLoader
     */
    private $loader;

    protected function setUp()
    {
        $this->loader = new YamlConfigLoader(__DIR__ . '/config.yaml');
    }

    public function testGetReceiverFilePath()
    {
        $this->assertSame('testFilePath/receiver.csv', $this->loader->getReceiverFilePath());
    }

    public function testGetHostFilePath()
    {
        $this->assertSame('testFilePath/host.csv', $this->loader->getHostFilePath());
    }

    public function testGetMergedFilePath()
    {
        $this->assertSame('testFilePath/merged.csv', $this->loader->getMergedFilePath());
    }

    public function testGetKeyHeader()
    {
        $this->assertSame([
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
        $this->assertSame([
            'headerHost1' => 'headerReceiver1',
            'headerHost2' => 'headerReceiver2',
        ],
            $this->loader->getMappingMigration());
    }

}