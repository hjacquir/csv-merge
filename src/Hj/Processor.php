<?php

namespace Hj;

class Processor
{
    /**
     * @param array $rowWhereToSaveData
     * @param array $rowWhereToGetData
     * @param Extractor $extractor
     * @param array $headers Mapping array between the column header that will host the data and the one where the data will be retrieved
     * @return bool
     * @throws Exception\UndefinedColumnException
     */
    public function process(array &$rowWhereToSaveData, array $rowWhereToGetData, Extractor $extractor, array $headers)
    {
        $response = $extractor->extractData($rowWhereToSaveData, $rowWhereToGetData, $headers);

        // si une deuxieme regle d'extraction a été définie et que l'élément n'a pas été trouvé avec la premiere
        if (false === $response && $extractor->hasSuccessor()) {
            $this->process($rowWhereToSaveData, $rowWhereToGetData, $extractor->getSuccessor(), $headers);
        }

        return $response;
    }
}