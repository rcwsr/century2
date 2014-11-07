<?php

namespace spec\Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Filter\DistanceFilter;
use Century\CenturyBundle\Sync\Synchronizer;
use Century\CenturyBundle\Sync\SynchronizerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Processor\Processor');
    }

    public function let(Synchronizer $sync, DocumentManager $documentManager, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $this->beConstructedWith($sync, $documentManager);
    }

    public function it_processes_empty_arrays_without_error(Synchronizer $sync)
    {
        $sync->sync([], [])->willReturn([]);
        $this->process([], [])->shouldReturn([]);
    }


}
