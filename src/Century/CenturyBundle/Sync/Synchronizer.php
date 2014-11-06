<?php

namespace Century\CenturyBundle\Sync;

use Century\CenturyBundle\Exception\UnsynchronizableException;
use Century\CenturyBundle\Sync\Model\SynchronizableInterface;

class Synchronizer implements SynchronizerInterface
{
    /**
     * @param array $existing
     * @param array $data
     * @throws UnsynchronizableException
     * @return array
     */
    public function sync(array $existing, array $data)
    {
        foreach(array_merge($existing, $data) as $obj){
            if(! $obj instanceof SynchronizableInterface){
                throw new UnsynchronizableException("Must implement SynchronizableInterface");
            }
        }

        //identifies any modified clubs
        foreach ($data as $obj) {
            foreach ($existing as $existing_obj) {
                if($obj->getId() == $existing_obj->getId()){
                    if(!$existing_obj->equals($obj)){
                        $obj->setInternalId($existing_obj->getInternalId());
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
}