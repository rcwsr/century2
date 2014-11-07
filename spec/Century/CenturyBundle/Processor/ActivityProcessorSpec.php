<?php

namespace spec\Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Filter\DistanceFilter;
use Century\CenturyBundle\Sync\SynchronizerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ActivityProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Processor\ActivityProcessor');
    }

    public function let(SynchronizerInterface $sync, DocumentManager $documentManager, DistanceFilter $distance_filter1, DistanceFilter $distance_filter2, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $this->beConstructedWith($sync, $documentManager);

        $activity1->getDistance()->willReturn(5000);
        $activity2->getDistance()->willReturn(8000);
        $activity3->getDistance()->willReturn(100);

        $existing_activity1->getDistance()->willReturn(1000);
        $existing_activity1->getDistance()->willReturn(2000);

        $distance_filter1->setOptions([
            'distance' => 100,
            'operator' => '>',
        ]);

        $distance_filter2->setOptions([
            'distance' => 8000,
            'operator' => '<',
        ]);

        $distance_filter1->filter([])->willReturn([]);
        $distance_filter2->filter([])->willReturn([]);

        $this->setFilters([
            $distance_filter1,
            $distance_filter2
        ]);

    }

    public function it_throws_an_exception_if_given_non_filter_obj(\stdClass $obj, $distance_filter1, $distance_filter2)
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetFilters([$obj, $distance_filter1, $distance_filter2]);
    }

    public function it_can_work_without_any_filters(SynchronizerInterface $sync, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $this->shouldNotThrow('\InvalidArgumentException')->duringSetFilters([]);

        $existing = [$existing_activity1, $existing_activity2];

        $activities = [$activity1, $activity2, $activity3];

        $sync->sync($existing, $activities)->willReturn($activities);
        $sync->getTrash()->willReturn([]);

        $this->process($existing, $activities)->shouldReturn($activities);
    }

    function it_can_filter_activities_with_one_filter(SynchronizerInterface $sync, DistanceFilter $distance_filter1, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $this->setFilters([
            $distance_filter1,
        ]);

        $distance_filter1->filter([
            $activity1, $activity2, $activity3
        ])->willReturn(
            [$activity1, $activity2]
        );

        $existing = [$existing_activity1, $existing_activity2];
        $activities = [$activity1, $activity2, $activity3];
        $sync->sync($existing, $activities)->willReturn($activities);
        $sync->getTrash()->willReturn([]);

        $this->process($existing, $activities)->shouldReturn([
            $activity1, $activity2
        ]);
    }

    function it_can_filter_activities_with_multiple_filters(SynchronizerInterface $sync, DistanceFilter $distance_filter1, DistanceFilter $distance_filter2, Activity $activity1, Activity $activity2, Activity $activity3, Activity $existing_activity1, Activity $existing_activity2)
    {
        $this->setFilters([
            $distance_filter1,
            $distance_filter2,
        ]);


        $distance_filter1->filter([
            $activity1, $activity2, $activity3
        ])->willReturn([
                $activity1, $activity2]
        );

        $distance_filter2->filter([
            $activity1, $activity2
        ])->willReturn([
                $activity1]
        );

        $existing = [$existing_activity1, $existing_activity2];
        $activities = [$activity1, $activity2, $activity3];
        $sync->sync($existing, $activities)->willReturn($activities);
        $sync->getTrash()->willReturn([]);

        $this->process($existing, $activities)->shouldReturn([$activity1]);
    }
}
