<?php

namespace Hj\File;

use Hj\Exception\FileNotFoundException;
use ParseCsv\Csv;

class HostFile extends File
{
    /**
     * HostFile constructor.
     * @param string $fileName
     * @param Csv $csvParser
     * @throws FileNotFoundException
     */
    public function __construct(string $fileName, Csv $csvParser)
    {
        parent::__construct($fileName, $csvParser);

    }
}