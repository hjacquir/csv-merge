<?php

namespace Hj\File;

use ParseCsv\Csv;

class HostFile extends File
{
    /**
     * @param $fileName
     * @param Csv $csvParser
     */
    public function __construct($fileName, Csv $csvParser)
    {
        parent::__construct($fileName, $csvParser);
        $this->getCsvParser()->auto($fileName);
    }

}