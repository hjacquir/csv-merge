<?php

namespace Hj\MappingRelation;

interface MappingRelation
{
    const ONE_TO_ONE = 'OneToOne';
    const MANY_TO_ONE = 'ManyToOne';

    public function map($value);
    public function isMappable();
}