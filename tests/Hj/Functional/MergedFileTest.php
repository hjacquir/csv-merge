<?php

namespace Hj\Functional;

use Hj\Extractor;
use Hj\File\HostFile;
use Hj\File\MergedFile;
use Hj\File\ReceiverFile;
use Hj\Processor;
use ParseCsv\Csv;
use PHPUnit\Framework\TestCase;

class MergedFileTest extends TestCase
{
    public function testCreateWithExtractorWithoutSuccessor()
    {
        $csvTestFilesBasePath = __DIR__ . '/csvFiles/';
        // we have to empty the file for the purposes of the test
        file_put_contents($csvTestFilesBasePath . 'merged.csv', '');

        $mergedFile = new MergedFile($csvTestFilesBasePath . 'merged.csv', new Csv());
        // the merged file is empty
        $expected = [];
        $this->assertEquals($expected, $mergedFile->getRows());

        $receiverFile = new ReceiverFile($csvTestFilesBasePath . 'receiver.csv', new Csv());
        // the receiver file referer column is empty
        $expected = array(
            0 =>
                array(
                    'header1' => 'blabla',
                    'Header 2' => 'hello',
                    'Header 3' => 'test bar',
                    'Referer' => '',
                ),
            1 =>
                array(
                    'header1' => 'bla',
                    'Header 2' => 'FOO',
                    'Header 3' => 'test foo',
                    'Referer' => '',
                ),
        );
        $this->assertEquals($expected, $receiverFile->getRows());

        $hostFile = new HostFile($csvTestFilesBasePath . 'host.csv', new Csv());
        // the host file referer column is valorized
        $expected = array(
            0 =>
                array(
                    'header1' => 'World',
                    'Header 2' => 'hello',
                    'Header 3' => 'bla',
                    'Header 4' => '411',
                ),
            1 =>
                array(
                    'header1' => 'bar',
                    'Header 2' => 'FOO',
                    'Header 3' => 'blabla',
                    'Header 4' => '7785',
                ),
        );
        $this->assertEquals($expected, $hostFile->getRows());
        // compare receiver file column 'header 1' to host file column 'Header 3'
        $extractor = new Extractor('header1', 'Header 3');
        $processor = new Processor();
        $mappingMigration = [
            // migrate host file column 'Header 4' value to -> receiver file column 'Referer'
            'Header 4' => 'Referer'
        ];
        $mergedFile->create($receiverFile, $hostFile, $processor, $extractor, $mappingMigration);
        // the merged file contains data from receiver file
        // and the referer column was valorized from host file data
        $expected = array(
            0 =>
                array(
                    'header1' => 'blabla', // = host file 'Header 3' and = receiver file 'header1'
                    'Header 2' => 'hello',
                    'Header 3' => 'test bar',
                    'Referer' => '7785', // = host file 'Header 4'
                ),
            1 =>
                array(
                    'header1' => 'bla', // = host file 'Header 3' and = receiver file 'header1'
                    'Header 2' => 'FOO',
                    'Header 3' => 'test foo',
                    'Referer' => '411', // = host file 'Header 4'
                ),
        );
        $mergedFileForAssertion = new MergedFile($csvTestFilesBasePath . 'merged.csv', new Csv());
        $this->assertEquals($expected, $mergedFileForAssertion->getRows());
    }

    public function testCreateWithExtractorWithSuccessor()
    {
        $csvTestFilesBasePath = __DIR__ . '/csvFiles/';
        // we have to empty the file for the purposes of the test
        file_put_contents($csvTestFilesBasePath . 'merged.csv', '');

        $mergedFile = new MergedFile($csvTestFilesBasePath . 'merged.csv', new Csv());
        // the merged file is empty
        $expected = [];
        $this->assertEquals($expected, $mergedFile->getRows());

        $receiverFile = new ReceiverFile($csvTestFilesBasePath . 'receiver.csv', new Csv());
        // the receiver file referer column is empty
        $expected = array(
            0 =>
                array(
                    'header1' => 'blabla',
                    'Header 2' => 'hello',
                    'Header 3' => 'test bar',
                    'Referer' => '',
                ),
            1 =>
                array(
                    'header1' => 'bla',
                    'Header 2' => 'FOO',
                    'Header 3' => 'test foo',
                    'Referer' => '',
                ),
        );
        $this->assertEquals($expected, $receiverFile->getRows());

        $hostFile = new HostFile($csvTestFilesBasePath . 'hostWithSuccessor.csv', new Csv());
        // the host file referer column is valorized
        $expected = array(
            0 =>
                array(
                    'header1' => 'World',
                    'Header 2' => 'hello',
                    'Header 3' => 'bla',
                    'Header 4' => '411',
                ),
            1 =>
                array(
                    'header1' => 'bar',
                    'Header 2' => 'FOO',
                    'Header 3' => 'test',
                    'Header 4' => '77',
                ),
            2 =>
                array(
                    'header1' => 'bar',
                    'Header 2' => 'blabla',
                    'Header 3' => 'Ipsum',
                    'Header 4' => '7785',
                ),
        );
        $this->assertEquals($expected, $hostFile->getRows());
        // compare receiver file column 'header 1' to host file column 'Header 3'
        $extractor = new Extractor('header1', 'Header 3');
        $successorExtractor = new Extractor('header1', 'Header 2');
        $extractor->setSuccessor($successorExtractor);
        $processor = new Processor();
        $mappingMigration = [
            // migrate host file column 'Header 4' value to -> receiver file column 'Referer'
            'Header 4' => 'Referer'
        ];
        $mergedFile->create($receiverFile, $hostFile, $processor, $extractor, $mappingMigration);
        // the merged file contains data from receiver file
        // and the referer column was valorized from host file data
        $expected = array(
            0 =>
                array(
                    'header1' => 'blabla', // = host file 'Header 3' and = receiver file 'header1'
                    'Header 2' => 'hello',
                    'Header 3' => 'test bar',
                    'Referer' => '7785', // = host file 'Header 2' (host file 'Header 4' is not matching so we use the other extractor)
                ),
            1 =>
                array(
                    'header1' => 'bla', // = host file 'Header 3' and = receiver file 'header1'
                    'Header 2' => 'FOO',
                    'Header 3' => 'test foo',
                    'Referer' => '411', // = host file 'Header 4'
                ),
        );
        $mergedFileForAssertion = new MergedFile($csvTestFilesBasePath . 'merged.csv', new Csv());
        $this->assertEquals($expected, $mergedFileForAssertion->getRows());
    }
}