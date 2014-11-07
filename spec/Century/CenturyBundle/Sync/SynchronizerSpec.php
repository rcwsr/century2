<?php

namespace spec\Century\CenturyBundle\Sync;

use Century\CenturyBundle\Sync\Model\SynchronizableInterface;
use MyProject\Proxies\__CG__\stdClass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SynchronizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Sync\Synchronizer');
    }

    public function let(SynchronizableInterface $modified_obj1, SynchronizableInterface $obj1, SynchronizableInterface $obj2, SynchronizableInterface $obj3, SynchronizableInterface $existing_obj1, SynchronizableInterface $existing_obj2)
    {
        $existing_obj1->getId()->willReturn(1);
        $existing_obj1->__toString()->willReturn('a');
        $existing_obj1->getInternalId()->willReturn(1001);

        $existing_obj2->getId()->willReturn(2);
        $existing_obj2->__toString()->willReturn('b');
        $existing_obj2->getInternalId()->willReturn(1002);

        $obj1->getId()->willReturn(101);
        $obj1->__toString()->willReturn('z');

        $obj2->getId()->willReturn(102);
        $obj2->__toString()->willReturn('y');

        $obj3->getId()->willReturn(103);
        $obj3->__toString()->willReturn('x');

        $modified_obj1->getId()->willReturn(1);
        $modified_obj1->__toString()->willReturn('modified');
    }

    function it_syncs_brand_new_activities(SynchronizableInterface $obj1, SynchronizableInterface $obj2, SynchronizableInterface $obj3, SynchronizableInterface $existing_obj1, SynchronizableInterface $existing_obj2)
    {
        $existing_obj1->equals(Argument::any())->willReturn(true);
        $existing_obj2->equals(Argument::any())->willReturn(true);

        $existing = [$existing_obj1, $existing_obj2];

        $this->sync($existing,
            [$existing_obj1, $existing_obj2, $obj1, $obj2, $obj3]
        )->shouldReturn([$obj1, $obj2, $obj3]);
    }

    function it_syncs_activities_that_have_changed(SynchronizableInterface $modified_obj1, SynchronizableInterface $obj1, SynchronizableInterface $obj2, SynchronizableInterface $obj3, SynchronizableInterface $existing_obj1, SynchronizableInterface $existing_obj2)
    {
        $existing = [$existing_obj1, $existing_obj2];

        $existing_obj1->equals($modified_obj1)->willReturn(false);
        $existing_obj2->equals(Argument::any())->willReturn(true);


        $modified_obj1->setInternalId(1001)->shouldBeCalled();

        $this->sync($existing,
            [$modified_obj1, $existing_obj2, $obj1, $obj2, $obj3]
        )->shouldReturn([$modified_obj1, $obj1, $obj2, $obj3]);
    }

    function it_handles_no_activities_without_error(SynchronizableInterface $existing_obj1, SynchronizableInterface $existing_obj2)
    {
        $existing = [$existing_obj1, $existing_obj2];
        $this->sync($existing, [])->shouldReturn([]);
        $this->shouldNotThrow('\Exception')->duringSync($existing, []);
    }

    function it_handles_no_data_without_error()
    {
        $this->sync([], [])->shouldReturn([]);
        $this->shouldNotThrow('\Exception')->duringSync([], []);
    }

    function it_throws_an_exception_if_incorrect_sync_obj_given(SynchronizableInterface $obj1)
    {
        $this->shouldThrow('Century\CenturyBundle\Exception\UnsynchronizableException')->duringSync([], [$obj1, "string"]);
        $this->shouldThrow('Century\CenturyBundle\Exception\UnsynchronizableException')->duringSync([$obj1, new \stdClass()], []);
        $this->shouldThrow('Century\CenturyBundle\Exception\UnsynchronizableException')->duringSync([1], [$obj1]);
    }

    
}
