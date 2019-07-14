<?php

namespace Hj\File;

use Hj\Exception\FileNotFoundException;
use ParseCsv\Csv;

abstract class File
{

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var Csv
     */
    public $csvParser;

    /**
     * File constructor.
     * @param string $fileName
     * @param Csv $csvParser
     * @throws FileNotFoundException
     */
    public function __construct(string $fileName, Csv $csvParser)
    {
        $this->fileName = $fileName;
        $this->fileExist($this->fileName);
        $this->csvParser = $csvParser;
        $this->getCsvParser()->auto($fileName);
    }

    /**
     * @param string $fileName
     * @throws FileNotFoundException
     */
    private function fileExist(string $fileName)
    {
        if (!file_exists($fileName)) {
            throw new FileNotFoundException("The file {$fileName} does not exist");
        }
    }

    /**
     * @return array
     */
    public function getRows() : array
    {
        return $this->getCsvParser()->data;
    }

    /**
     * @return string
     */
    public function getFileName() : string
    {
        return $this->fileName;
    }

    /**
     * @return Csv
     */
    public function getCsvParser() : Csv
    {
        return $this->csvParser;
    }
}