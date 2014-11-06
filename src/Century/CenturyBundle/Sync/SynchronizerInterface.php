<?php

namespace Century\CenturyBundle\Sync;

interface SynchronizerInterface
{
    public function sync(array $existing, array $data);
} 