<?php

namespace Hj\Tests\Functional;

use Hj\File\ReceiverFile;
use ParseCsv\Csv;
use PHPUnit\Framework\TestCase;

class ReceiverFileTest extends TestCase
{
    /**
     * @var ReceiverFile
     */
    private $receiverFile;

    protected function setUp()
    {
        $this->receiverFile = new ReceiverFile(__DIR__ . '/csvFiles/bla.csv', new Csv());
    }

    public function testGetRowsReturnRows()
    {
        $expected = [
            0 => [
                'header1' => 'World',
                'Header 2' => 'hello',
            ],
            1 => [
                'header1' => 'bar',
                'Header 2' => 'FOO',
            ],
        ];

        $this->assertEquals($expected, $this->receiverFile->getRows());
    }

    public function testGetHeaderReturnHeaderAsString()
    {
        $this->assertEquals('header1;Header 2', $this->receiverFile->getHeaderAsString());

    }
}