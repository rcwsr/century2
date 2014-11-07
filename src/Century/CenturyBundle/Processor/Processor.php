<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Sync\SynchronizerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Processor implements ProcessorInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @var SynchronizerInterface
     */
    protected $sync;

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
     * @param array $existing
     * @param array $data
     * @return array
     */
    protected function sync(array $existing, array $data)
    {
        $data = $this->sync->sync($existing, $data);
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function persist(array $data)
    {
        foreach($data as $object){
            $this->objectManager->persist($object);
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
        $data = $this->persist($data);
        return $data;
    }
}
