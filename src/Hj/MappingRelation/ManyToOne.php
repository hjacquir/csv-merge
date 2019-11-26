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

    public function map($value)
    {
        // do nothing here
    }

    public function isMappable()
    {
        return $this->yamlConfigLoader->getMappingRelation() === MappingRelation::MANY_TO_ONE;
    }
}