<?php

namespace Century\CenturyBundle\Sync\Model;

interface SynchronizableInterface
{
    public function hash();

    public function equals(SynchronizableInterface $model);

    public function __toString();

    public function getInternalId();

    public function setInternalId($id);

    public function getId();
} 