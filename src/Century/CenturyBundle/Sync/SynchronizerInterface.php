<?php

namespace Century\CenturyBundle\Sync;

interface SynchronizerInterface
{
    /**
     * @param array $existing
     * @param array $data
     * @return array
     */
    public function sync(array $existing, array $data);

    /**
     * @return array
     */
    public function getTrash();
} 