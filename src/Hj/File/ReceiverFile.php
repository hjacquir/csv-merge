<?php

namespace Hj\File;

use ParseCsv\Csv;

class ReceiverFile extends File
{
    /**
     * @param $fileName
     * @param Csv $csvParser
     */
    public function __construct($fileName, Csv $csvParser)
    {
        parent::__construct($fileName, $csvParser);
        $this->getCsvParser()->auto($fileName);
        $this->getCsvParser()->heading = false;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        $headerArray = array_keys($this->getCsvParser()->data[0]);
        $headerString = implode(';', $headerArray);

        return $headerString;
    }
}