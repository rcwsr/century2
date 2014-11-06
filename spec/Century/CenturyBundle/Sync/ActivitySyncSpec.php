<?php

namespace spec\Century\CenturyBundle\Sync;

use PhpSpec\ObjectBehavior;
use Century\CenturyBundle\Document\Activity;
use Prophecy\Argument;

class ActivitySyncSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Sync\ActivitySync');
    }

    public function let(Activity $modified_activity1, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {

        $activity1->getDistance()->willReturn(5000);
        $activity1->getId()->willReturn(101);
        $activity1->__toString()->willReturn(sprintf('%d_%d', 101, 5000));
        $activity2->getDistance()->willReturn(8000);
        $activity2->getId()->willReturn(102);
        $activity2->__toString()->willReturn(sprintf('%d_%d', 102, 8000));
        $activity3->getDistance()->willReturn(100);
        $activity3->getId()->willReturn(103);
        $activity3->__toString()->willReturn(sprintf('%d_%d', 103, 100));

        $modified_activity1->getDistance()->willReturn(700);
        $modified_activity1->getId()->willReturn(1);
        $modified_activity1->__toString()->willReturn(sprintf('%d_%d', 1, 700));


        $existing_activity1->getDistance()->willReturn(500);
        $existing_activity1->getId()->willReturn(1);
        $existing_activity1->__toString()->willReturn(sprintf('%d_%d', 1, 500));
        $existing_activity1->getInternalId()->willReturn(1001);
        $existing_activity2->getDistance()->willReturn(2000);
        $existing_activity2->getId()->willReturn(2);
        $existing_activity2->__toString()->willReturn(sprintf('%d_%d', 2, 2000));
        $existing_activity2->getInternalId()->willReturn(501);
    }

    function it_syncs_brand_new_activities(Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {

        $existing_activity1->equals(Argument::any())->willReturn(true);
        $existing_activity2->equals(Argument::any())->willReturn(true);

        $existing = [$existing_activity1, $existing_activity2];

        $this->sync($existing,
            [$existing_activity1, $existing_activity2, $activity1, $activity2, $activity3]
        )->shouldReturn([$activity1, $activity2, $activity3]);
    }

    function it_syncs_activities_that_have_changed(Activity $modified_activity1, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $existing = [$existing_activity1, $existing_activity2];

        $existing_activity1->equals($modified_activity1)->willReturn(false);
        $existing_activity2->equals(Argument::any())->willReturn(true);


        $modified_activity1->setInternalId(1001)->shouldBeCalled();

        $this->sync($existing,
            [$modified_activity1, $existing_activity2, $activity1, $activity2, $activity3]
        )->shouldReturn([$modified_activity1, $activity1, $activity2, $activity3]);
    }

    function it_handles_no_activities_without_error(Activity $existing_activity1, Activity $existing_activity2)
    {
        $existing = [$existing_activity1, $existing_activity2];
        $this->sync($existing, [])->shouldReturn([]);
        $this->shouldNotThrow('\Exception')->duringSync($existing, []);
    }
}
