<?php

namespace Hj;

class Processor
{
    /**
     * @param $rowWhereToSaveData
     * @param $rowWhereToGetData
     * @param $headerWhereToSaveData
     * @param $headerWhereToGetData
     * @param Extractor $extractor
     */
    public function process(&$rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData, Extractor $extractor)
    {
        $response = $extractor->extractData($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData);

        if (false === $response && $extractor->hasSuccessor()) {
            $this->process($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData, $extractor->getSuccessor());
        }
    }
}