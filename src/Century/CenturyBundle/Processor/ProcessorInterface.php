<?php

namespace Century\CenturyBundle\Processor;


interface ProcessorInterface
{
    public function setFilters(array $filters);

    public function process();
} 