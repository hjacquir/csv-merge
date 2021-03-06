<?php

namespace Hj;

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
    public function __construct(string $headerComparisonWhereToSaveData, string $headerComparisonWhereToGetData)
    {
        $this->headerComparisonWhereToSaveData = trim($headerComparisonWhereToSaveData);
        $this->headerComparisonWhereToGetData = trim($headerComparisonWhereToGetData);
    }

    /**
     * @param array $rowWhereToSaveData
     * @param array $rowWhereToGetData
     * @param array $headers
     * @return bool
     */
    public function extractData(array &$rowWhereToSaveData, array $rowWhereToGetData, array $headers) : bool
    {
        if (trim($rowWhereToSaveData[$this->headerComparisonWhereToSaveData]) == trim($rowWhereToGetData[$this->headerComparisonWhereToGetData])) {
            // on parcourt toutes les colonnes de mapping
            foreach ($headers as $headerWhereToGetData => $headerWhereToSaveData) {
                $this->sanitizeValue($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData);
                $rowWhereToSaveData[$headerWhereToSaveData] = $rowWhereToGetData[$headerWhereToGetData];
            }

            return true;
        }

        return false;
    }

    /**
     * @param array $rowWhereToSaveData
     * @param array $rowWhereToGetData
     * @param string $headerWhereToSaveData
     * @param string $headerWhereToGetData
     */
    private function sanitizeValue(array &$rowWhereToSaveData, array &$rowWhereToGetData, string $headerWhereToSaveData, string $headerWhereToGetData)
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
    public function getSuccessor() : Extractor
    {
        return $this->successor;
    }

    /**
     * @return bool
     */
    public function hasSuccessor() : bool
    {
        return $this->successor !== null;
    }
}