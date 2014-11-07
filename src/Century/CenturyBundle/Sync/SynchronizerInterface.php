<?php

namespace Century\CenturyBundle\Sync;

interface SynchronizerInterface
{
    /**
     * @param array $existing
     * @param array $data
     * @return mixed
     */
    public function sync(array $existing, array $data);
} 