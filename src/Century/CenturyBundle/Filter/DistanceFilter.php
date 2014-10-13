<?php


namespace Century\CenturyBundle\Filter;

class DistanceFilter implements FilterInterface
{
    private $distance;
    private $operator;

    /**
     * @param array $activities
     * @return array
     */
    public function filter(array $activities)
    {
        $filtered_activities = [];

        foreach ($activities as $activity) {
            $distance = (int) $activity->getDistance();

            switch ($this->operator) {
                case '>':
                    if ($distance > $this->distance)
                        $filtered_activities[] = $activity;
                    break;
                case '<':
                    if ($distance < $this->distance)
                        $filtered_activities[] = $activity;
                    break;
                case '<=':
                    if ($distance <= $this->distance)
                        $filtered_activities[] = $activity;
                    break;
                case '>=':
                    if ($distance >= $this->distance)
                        $filtered_activities[] = $activity;
                    break;
                default: throw new \InvalidArgumentException();
            }
        }

        return $filtered_activities;
    }

    /**
     * @param array $options
     * @return $this|FilterInterface
     */
    public function setOptions(array $options)
    {
        $this->distance = $options['distance'];
        $this->operator = $options['operator'];
        return $this;
    }
}
