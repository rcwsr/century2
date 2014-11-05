<?php

namespace Century\CenturyBundle\Sync;

class ActivitySync implements SyncInterface
{
    /**
     * @param array $existing
     * @param array $data
     * @return array
     */
    public function sync(array $existing, array $data)
    {
        //identifies any modified activities
        foreach ($data as $activity) {
            foreach ($existing as $existing_activity) {
                if($activity->getId() == $existing_activity->getId()){
                    if(!$existing_activity->equals($activity)){
                        $activity->setInternalId($existing_activity->getInternalId());
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