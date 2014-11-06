<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\User;

interface ProcessorInterface
{
    public function setFilters(array $filters);

    public function process(array $existing, array $data);

    public function sync(array $existing, array $data);

    public function persist(array $data);
} 