<?php

namespace Century\CenturyBundle\Filter;

class Filterer
{
    private $filters;

    /**
     * @param array $filters
     */
    public function setFilters(array $filters)
    {
        foreach($filters as $filter){
            if(!$filter instanceof FilterInterface){
                throw new \InvalidArgumentException("Filters must implement FilterInterface");
            }
        }
        $this->filters = $filters;
    }

    /**
     * @param array $activities
     * @return array
     */
    public function performFilters(array $activities)
    {
        foreach($this->filters as $filter){
            $activities = $filter->filter($activities);
        }
        return $activities;
    }
}
