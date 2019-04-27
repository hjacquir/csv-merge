<?php

namespace Hj\File;

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
        $this->csvParser = $csvParser;
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