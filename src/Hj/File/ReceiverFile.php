<?php

namespace Hj\File;

use Hj\Exception\FileNotFoundException;
use ParseCsv\Csv;

class ReceiverFile extends File
{
    /**
     * ReceiverFile constructor.
     * @param string $fileName
     * @param Csv $csvParser
     * @throws FileNotFoundException
     */
    public function __construct(string $fileName, Csv $csvParser)
    {
        parent::__construct($fileName, $csvParser);
        $this->getCsvParser()->heading = false;
    }

    /**
     * @return string
     */
    public function getHeaderAsString() : string
    {
        $headerArray = $this->getHeaderAsArray();
        $headerString = implode(';', $headerArray);

        return $headerString;
    }
}