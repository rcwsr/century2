<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Filter\FilterInterface;

class ActivityProcessor implements ProcessorInterface
{

    private $filters;
    private $data;

    /**
     * @param array $filters
     */
    public function setFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException("Filters must implement FilterInterface");
            }
        }
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    private function performFilters()
    {
        if(!empty($this->filters)){
            foreach ($this->filters as $filter) {
                $this->data = $filter->filter($this->data);
            }
        }

    }

    /**
     * @return array $activities
     */
    public function process()
    {
        $this->performFilters();

        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

} 