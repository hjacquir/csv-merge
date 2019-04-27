<?php

namespace Hj\Unit;

use Hj\Extractor;
use PHPUnit\Framework\TestCase;

class ExtractorTest extends TestCase
{
    public function testHasSuccessorReturnFalseWhenSuccessorNotExist()
    {
        $extractor = new Extractor('foo', 'bar');
        $this->assertFalse($extractor->hasSuccessor());
    }

    public function testHasSuccessorReturnTrueWhenSuccessorExist()
    {
        $extractor = new Extractor('foo', 'bar');
        $extractor->setSuccessor(new Extractor('hello', 'world'));
        $this->assertTrue($extractor->hasSuccessor());
    }

    public function testExtractDataReturnTrueAndMigrateDataWhenKeyIsIdentical()
    {
        $extractor = new Extractor('foo', 'bar');
        $row1 = [
            'foo' => 'bla',
            'hello' => '',
        ];
        $row2 = [
            'bar' => 'bla',
            'foo' => 'world',
        ];
        $response = $extractor->extractData($row1, $row2, 'hello', 'foo');
        $this->assertTrue($response);
        // data world was migrated
        $this->assertEquals([
            'foo' => 'bla',
            'hello' => 'world',
        ], $row1);
    }

    public function testExtractDataReturnFalseAndNotMigrateDataWhenKeyIsNotIdentical()
    {
        $extractor = new Extractor('foo', 'bar');
        $row1 = [
            'foo' => 'blabla',
            'hello' => '',
        ];
        $row2 = [
            'bar' => 'bla',
            'foo' => 'world',
        ];
        $response = $extractor->extractData($row1, $row2, 'hello', 'foo');
        $this->assertFalse($response);
        // data world was not migrated
        $this->assertEquals([
            'foo' => 'blabla',
            'hello' => '',
        ], $row1);
    }

    public function testExtractDataSanitizeValueBeforeExtrating()
    {
        $extractor = new Extractor('foo', 'bar');
        $row1 = [
            'foo' => 'bla',
            'hello' => 'not world',
        ];
        $row2 = [
            'bar' => 'bla',
            'foo' => 'NULL',
        ];
        $response = $extractor->extractData($row1, $row2, 'hello', 'foo');
        $this->assertTrue($response);
        // not world value is removed
        // NULL value is replaced by an empty string ''
        $this->assertEquals([
            'foo' => 'bla',
            'hello' => '',
        ], $row1);
    }
}