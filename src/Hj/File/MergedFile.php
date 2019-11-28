<?php

namespace Hj\File;

use Hj\ConfigHeaderValidator;
use Hj\Exception\FileNotFoundException;
use Hj\Exception\UndefinedColumnException;
use Hj\Extractor;
use Hj\Processor;
use Monolog\Logger;
use ParseCsv\Csv;

class MergedFile extends File
{
    /**
     * @var array MappingRelation[]
     */
    private $mappingRelation = [];

    /**
     * MergedFile constructor.
     * @param string $fileName
     * @param Csv $csvParser
     * @param array $mappingRelation
     * @throws FileNotFoundException
     */
    public function __construct(string $fileName, Csv $csvParser, array $mappingRelation)
    {
        parent::__construct($fileName, $csvParser);
        $this->getCsvParser()->enclosure = '';
        $this->mappingRelation = $mappingRelation;
    }

    /**
     * @param ReceiverFile $receiverFile File that will host the extracted data
     * @param HostFile $hostFile File that contains the data to retrieve
     * @param Processor $processor
     * @param Extractor $extractor
     * @param array $headers Mapping array between the column header that will host the data and the one where the data will be retrieved
     * @param ConfigHeaderValidator $configHeaderValidator
     * @param Logger $logger
     * @throws UndefinedColumnException
     */
    public function create(ReceiverFile $receiverFile, HostFile $hostFile, Processor $processor, Extractor $extractor, array $headers, ConfigHeaderValidator $configHeaderValidator, Logger $logger)
    {
        $configHeaderValidator->valid();
        $receiverRows = $receiverFile->getRows();
        $hostRows = $hostFile->getRows();

        $this->removeFileIfExistAndAddHeader($receiverFile->getHeaderAsString());
        $logger->info("Header was added to merged file ...");
        $logger->info("Migration operation was started ...");

        foreach ($receiverRows as $rowNumber => &$receiverRow) {
            foreach ($hostRows as $key => $hostRow) {
                $response = $processor->process($receiverRow, $hostRow, $extractor, $headers);
                // si la response = true, la reference a ete trouvée on sort de la boucle
                // @todo : add migrationRelation condition
                if ($response) {
                    foreach ($this->mappingRelation as $mappingRelation) {
                        $hostRows = $mappingRelation->map($hostRows, $key);
                    }
                    break;
                }
            }
            $receiverRow = implode(';', $receiverRow);

            $this->appendRow($receiverRow);
        }
        $logger->info("Migration operation done successfully ...");
    }

    /**
     * @param string $row
     */
    private function appendRow(string $row)
    {
        $this->getCsvParser()->save($this->getFileName(), array(
            array($row)
        ), true);
    }

    /**
     * @param string $headerString
     */
    private function removeFileIfExistAndAddHeader(string $headerString)
    {
        if (file_exists($this->getFileName())) {
            unlink($this->getFileName());
        }

        $this->getCsvParser()->save($this->getFileName(), array(
            array($headerString)
        ), true);
    }
}