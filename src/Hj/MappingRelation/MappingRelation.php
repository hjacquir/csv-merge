<?php

namespace Hj\MappingRelation;

interface MappingRelation
{
    const ONE_TO_ONE = 'OneToOne';

    public function map($value, $key);
}