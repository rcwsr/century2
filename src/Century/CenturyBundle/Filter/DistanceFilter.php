<?php


namespace Century\CenturyBundle\Filter;

class DistanceFilter implements FilterInterface
{
    private $distance;
    private $operator;
    private $activities;

    /**
     * @return array
     */
    public function filter()
    {
        $activities = [];

        foreach ($this->activities as $activity) {
            $distance = (int) $activity['distance'];

            switch ($this->operator) {
                case '>':
                    if ($distance > $this->distance)
                        $activities[] = $activity;
                    break;
                case '<':
                    if ($distance < $this->distance)
                        $activities[] = $activity;
                    break;
                case '<=':
                    if ($distance <= $this->distance)
                        $activities[] = $activity;
                    break;
                case '>=':
                    if ($distance >= $this->distance)
                        $activities[] = $activity;
                    break;
                default: throw new \InvalidArgumentException();
            }
        }

        return $activities;
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

    /**
     * @param array $activities
     * @return $this|FilterInterface
     */
    public function setActivities(array $activities)
    {
        $this->activities = $activities;
        return $this;
    }
}
