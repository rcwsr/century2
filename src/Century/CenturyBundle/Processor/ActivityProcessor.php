<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Filter\FilterInterface;
use Century\CenturyBundle\Sync\SynchronizerInterface;
use Century\CenturyBundle\Sync\SyncInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityProcessor implements ProcessorInterface
{

    private $filters;
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var SynchronizerInterface
     */
    private $sync;

    /**
     * @param SynchronizerInterface $sync
     * @param ObjectManager $objectManager
     */
    public function __construct(SynchronizerInterface $sync, ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->sync = $sync;
    }

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
    public function filter(array $data)
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
     * @return array
     */
    public function sync(array $existing, array $data)
    {
        $data = $this->sync->sync($existing, $data);
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function persist(array $data)
    {
        foreach($data as $activity){
            $this->objectManager->persist($activity);
            $this->objectManager->flush();
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
        return $data;
    }
}
