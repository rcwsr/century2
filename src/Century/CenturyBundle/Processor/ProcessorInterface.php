<?php

namespace Century\CenturyBundle\Processor;

interface ProcessorInterface
{
    public function process(array $existing, array $data);
} 