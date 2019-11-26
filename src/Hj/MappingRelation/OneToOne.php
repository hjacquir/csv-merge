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

    public function map($value)
    {
        unset($value);
    }

    public function isMappable()
    {
        return $this->yamlConfigLoader->getMappingRelation() === MappingRelation::ONE_TO_ONE;
    }
}