<?php

namespace Hj\MappingRelation;

use Hj\YamlConfigLoader;

class ManyToOne implements MappingRelation
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
        // do nothing here
        return $value;
    }
}