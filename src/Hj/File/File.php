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
     * @param $fileName
     * @param Csv $csvParser
     */
    public function __construct($fileName, Csv $csvParser)
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
    private function fileExist($fileName)
    {
        if (!file_exists($fileName)) {
            throw new FileNotFoundException("The file {$fileName} does not exist");
        }
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->getCsvParser()->data;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return Csv
     */
    public function getCsvParser()
    {
        return $this->csvParser;
    }
}