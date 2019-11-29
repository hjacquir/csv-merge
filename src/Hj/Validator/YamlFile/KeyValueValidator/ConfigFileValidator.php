<?php

namespace Hj\Validator\YamlFile\KeyValueValidator;

use Hj\Exception\YamlKeyNotDefined;
use Hj\Exception\YamlValueWrongFormat;
use Hj\YamlConfigLoader;

/**
 * Class ConfigFileValidator
 * @package Hj\Validator
 */
class ConfigFileValidator extends KeyValueValidator
{
    /**
     * @param $value
     * @throws YamlKeyNotDefined
     * @throws YamlValueWrongFormat
     * @todo : add other validation
     */
    protected function isValid($value)
    {
        $this->validKey($value, YamlConfigLoader::KEY_FILE_PATH);
        $this->validKey($value, YamlConfigLoader::KEY_KEYHEADER);
        $this->validKey($value, YamlConfigLoader::KEY_MIGRATION_MAPPING);
        $this->validKey($value, YamlConfigLoader::KEY_MAPPING_RELATION);

        $this->valueIsArray($value[YamlConfigLoader::KEY_FILE_PATH], YamlConfigLoader::KEY_FILE_PATH);
        $this->valueIsString($value[YamlConfigLoader::KEY_FILE_PATH][YamlConfigLoader::KEY_RECEIVER], YamlConfigLoader::KEY_RECEIVER);
        $this->valueIsString($value[YamlConfigLoader::KEY_FILE_PATH][YamlConfigLoader::KEY_HOST], YamlConfigLoader::KEY_HOST);
        $this->valueIsString($value[YamlConfigLoader::KEY_FILE_PATH][YamlConfigLoader::KEY_MERGED], YamlConfigLoader::KEY_MERGED);
        $this->valueIsString($value[YamlConfigLoader::KEY_MAPPING_RELATION], YamlConfigLoader::KEY_MAPPING_RELATION);

        $this->valueIsArray($value[YamlConfigLoader::KEY_KEYHEADER], YamlConfigLoader::KEY_KEYHEADER);

        $this->authorizedValues($value[YamlConfigLoader::KEY_MAPPING_RELATION], YamlConfigLoader::KEY_MAPPING_RELATION, YamlConfigLoader::MAPPING_RELATION_AUTHORIZED_VALUES);;
    }
}