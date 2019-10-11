<?php

namespace Hj\File;

use Hj\Exception\FileNotFoundException;
use Hj\Exception\UndefinedColumnException;
use Hj\Extractor;
use Hj\Processor;
use ParseCsv\Csv;

class MergedFile extends File
{
    /**
     * MergedFile constructor.
     * @param string $fileName
     * @param Csv $csvParser
     * @throws FileNotFoundException
     */
    public function __construct(string $fileName, Csv $csvParser)
    {
        parent::__construct($fileName, $csvParser);
        $this->getCsvParser()->enclosure = '';
    }

    /**
     * @param ReceiverFile $receiverFile File that will host the extracted data
     * @param HostFile $hostFile File that contains the data to retrieve
     * @param Processor $processor
     * @param Extractor $extractor
     * @param array $headers Mapping array between the column header that will host the data and the one where the data will be retrieved
     * @throws UndefinedColumnException
     */
    public function create(ReceiverFile $receiverFile, HostFile $hostFile, Processor $processor, Extractor $extractor, array $headers)
    {
        $receiverRows = $receiverFile->getRows();
        $hostRows = $hostFile->getRows();

        foreach ($receiverRows as $rowNumber => &$receiverRow) {
            foreach ($hostRows as $key => $hostRow) {
                $response = $processor->process($receiverRow, $hostRow, $extractor, $headers);
                // si la response = true, la reference a ete trouvée on sort de la boucle
                if ($response) {
                    // on supprime la derniere reference trouvée pour ne plus l'inclure dans la recherche
                    unset($hostRows[$key]);
                    break;
                }
            }
            $receiverRow = implode(';', $receiverRow);
        }

        $this->save($receiverFile->getHeader(), $receiverRows);
    }

    /**
     * @param string $headerString
     * @param array $rows
     */
    private function save(string $headerString, array $rows)
    {
        if (file_exists($this->getFileName())) {
            unlink($this->getFileName());
        }

        $this->getCsvParser()->save($this->getFileName(), array(
            array($headerString)
        ), true);

        foreach ($rows as $item) {
            $this->getCsvParser()->save($this->getFileName(), array(
                array($item)
            ), true);
        }
    }
}