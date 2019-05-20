<?php

namespace Hj;

use Hj\Exception\UndefinedColumnException;

class Extractor
{

    /**
     * @var string
     */
    private $headerComparisonWhereToSaveData;

    /**
     * @var string
     */
    private $headerComparisonWhereToGetData;

    /**
     * @var Extractor
     */
    private $successor = null;

    /**
     * @param string $headerComparisonWhereToSaveData Comparison column header of the file hosting the data
     * @param string $headerComparisonWhereToGetData Comparison column header of the file where the data will be retrieved
     */
    public function __construct($headerComparisonWhereToSaveData, $headerComparisonWhereToGetData)
    {
        $this->headerComparisonWhereToSaveData = trim($headerComparisonWhereToSaveData);
        $this->headerComparisonWhereToGetData = trim($headerComparisonWhereToGetData);
    }

    /**
     * @param $rowWhereToSaveData
     * @param $rowWhereToGetData
     * @param $headerWhereToSaveData
     * @param $headerWhereToGetData
     * @return bool
     *
     * @throws UndefinedColumnException
     */
    public function extractData(&$rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData)
    {
       $this->ckeckHeader($this->headerComparisonWhereToSaveData, $rowWhereToSaveData);
       $this->ckeckHeader($this->headerComparisonWhereToGetData, $rowWhereToGetData);
        $this->ckeckHeader($headerWhereToSaveData, $rowWhereToSaveData);
        $this->ckeckHeader($headerWhereToGetData, $rowWhereToGetData);

        if (trim($rowWhereToSaveData[$this->headerComparisonWhereToSaveData]) == trim($rowWhereToGetData[$this->headerComparisonWhereToGetData])) {
            $this->sanitizeValue($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData);
            $rowWhereToSaveData[$headerWhereToSaveData] = $rowWhereToGetData[$headerWhereToGetData];

            return true;
        }

        return false;
    }

    /**
     * @param $headerName
     * @param $row
     *
     * @throws UndefinedColumnException
     */
    private function ckeckHeader($headerName, $row) {
        if (!isset($row[$headerName])) {
            throw new UndefinedColumnException("The header : {$headerName} does not exist. Please check your csv file or your config yaml file.");
        }
    }

    /**
     * @param array $rowWhereToSaveData
     * @param array $rowWhereToGetData
     * @param string $headerWhereToSaveData
     * @param string $headerWhereToGetData
     */
    private function sanitizeValue(&$rowWhereToSaveData, &$rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData)
    {
        // sanitize value and set as empty string before saving
        $rowWhereToSaveData[$headerWhereToSaveData] = '';
        // if result of export database and csv contain NULL -> sanitize it and set empty string
        if ($rowWhereToGetData[$headerWhereToGetData] == 'NULL') {
            $rowWhereToGetData[$headerWhereToGetData] = '';
        }
    }

    /**
     * @param Extractor $extractor
     */
    public function setSuccessor(Extractor $extractor)
    {
        $this->successor = $extractor;
    }

    /**
     * @return Extractor
     */
    public function getSuccessor()
    {
        return $this->successor;
    }

    /**
     * @return bool
     */
    public function hasSuccessor()
    {
        return $this->successor !== null;
    }
}