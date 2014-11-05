<?php

namespace Century\CenturyBundle\Sync;

interface SyncInterface
{
    public function sync(array $existing, array $data);
} 