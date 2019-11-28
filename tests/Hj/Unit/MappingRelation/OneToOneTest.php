<?php

namespace Hj\Tests\Unit\MappingRelation;

use Hj\MappingRelation\OneToOne;
use Hj\YamlConfigLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OneToOneTest extends TestCase
{
    /**
     * @var YamlConfigLoader | MockObject
     */
    private $loader;

    public function testMap()
    {
        $this->loader = parent::getMockBuilder(YamlConfigLoader::class)
        ->disableOriginalConstructor()
        ->getMock();
        $this->loader->method('getMappingRelation')
            ->willReturn('OneToOne');
        $arrayValues = [
            'a',
            'b',
            'c',
            'a',
        ];
        $oneToOne = new OneToOne($this->loader);
        $arrayValues = $oneToOne->map($arrayValues, 0);
        parent::assertSame(
            [
                'b',
                'c',
                'a',
            ],
            $arrayValues
        );
    }
}