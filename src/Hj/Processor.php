<?php

namespace Hj;

class Processor
{
    /**
     * @param array $rowWhereToSaveData
     * @param array $rowWhereToGetData
     * @param string $headerWhereToSaveData
     * @param string $headerWhereToGetData
     * @param Extractor $extractor
     * @throws Exception\UndefinedColumnException
     */
    public function process(array &$rowWhereToSaveData, array $rowWhereToGetData, string $headerWhereToSaveData, string $headerWhereToGetData, Extractor $extractor)
    {
        $response = $extractor->extractData($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData);

        if (false === $response && $extractor->hasSuccessor()) {
            $this->process($rowWhereToSaveData, $rowWhereToGetData, $headerWhereToSaveData, $headerWhereToGetData, $extractor->getSuccessor());
        }
    }
}