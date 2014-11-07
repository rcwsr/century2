<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Filter\FilterInterface;

class ActivityProcessor extends Processor
{

    private $filters;

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException("Filters must implement FilterInterface");
            }
        }
        $this->filters = $filters;
        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function filter(array $data)
    {
        if ($this->filters) {
            foreach ($this->filters as $filter) {
                $data = $filter->filter($data);
            }
        }
        return $data;
    }

    /**
     * @param array $existing
     * @param array $data
     * @return array $activities
     */
    public function process(array $existing, array $data)
    {
        $data = $this->sync($existing, $data);
        $data = $this->filter($data);
        $data = $this->persist($data);

        $this->remove($this->sync->getTrash());

        $this->objectManager->flush();
        return $data;
    }
}
