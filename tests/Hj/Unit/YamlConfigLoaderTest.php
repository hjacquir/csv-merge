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
            'keyHeaderReceiver' => 'keyHeaderHost',
            'keyHeaderReceiver2' => 'keyHeaderHost2',
        ],
            $this->loader->getKeyHeader());
    }

    public function testGetMappingMigration()
    {
        $this->assertSame([
            'valueHost1' => 'valueReceiver1',
            'valueHost2' => 'valueReceiver2',
        ],
            $this->loader->getMappingMigration());
    }

}