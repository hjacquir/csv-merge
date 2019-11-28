<?php

namespace Hj\MappingRelation;

use Hj\YamlConfigLoader;

class OneToOne implements MappingRelation
{
    /**
     * @var YamlConfigLoader
     */
    private $yamlConfigLoader;

    public function __construct(YamlConfigLoader $yamlConfigLoader)
    {
        $this->yamlConfigLoader = $yamlConfigLoader;
    }

    /**
     * @param $value
     * @param $key
     * @return array
     */
    public function map($value, $key)
    {
        if ($this->yamlConfigLoader->getMappingRelation() === MappingRelation::ONE_TO_ONE) {
            array_splice($value, $key, 1);
        }
        return $value;
    }
}