<?php

namespace Century\CenturyBundle\Sync;

use Century\CenturyBundle\Exception\UnsynchronizableException;
use Century\CenturyBundle\Sync\Model\SynchronizableInterface;

class Synchronizer implements SynchronizerInterface
{
    protected $trash = [];

    /**
     * @param SynchronizableInterface[] $existing
     * @param SynchronizableInterface[] $data
     * @throws UnsynchronizableException
     * @return array
     */
    public function sync(array $existing, array $data)
    {
        foreach (array_merge($existing, $data) as $obj) {
            if (!$obj instanceof SynchronizableInterface) {
                throw new UnsynchronizableException("Must implement SynchronizableInterface");
            }
        }

        $remove = array_diff($existing, $data);
        $this->trash = array_values($remove);

        foreach ($data as $obj) {
            foreach ($existing as $existingObj) {
                if ($obj->getStravaId() == $existingObj->getStravaId()) {
                    if (!$existingObj->equals($obj)) {
                        $obj->setId($existingObj->getId());
                    }
                }
            }
        }

        //filters any existing activities
        $synced = array_diff($data, $existing);
        //resets array keys
        $synced = array_values($synced);

        return $synced;
    }

    public function getTrash(){
        return $this->trash;
    }
}