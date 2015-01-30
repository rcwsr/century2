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
     * @return array $activities
     */
    public function process(array $existing, array $data)
    {
        $synceData = $this->sync->sync($existing, $data);

        foreach($synceData as $object){
            $this->objectManager->persist($object);
        }

        foreach($this->sync->getTrash() as $object){
            $this->objectManager->remove($object);
        }

        $this->objectManager->flush();

        return $data;
    }
}
