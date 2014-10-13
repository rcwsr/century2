<?php

namespace spec\Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Filter\DistanceFilter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ActivityProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Processor\ActivityProcessor');
    }

    public function let(DistanceFilter $distance_filter1, DistanceFilter $distance_filter2, Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $activity1->getDistance()->willReturn(5000);
        $activity2->getDistance()->willReturn(8000);
        $activity3->getDistance()->willReturn(100);

        $distance_filter1->setOptions([]);
        $distance_filter1->filter([])->willReturn([]);
        $distance_filter2->setOptions([]);
        $distance_filter2->filter([])->willReturn([]);

        $this->setFilters([
            $distance_filter1,
            $distance_filter2
        ]);

        $this->setData([
            $activity1, $activity2, $activity3
        ]);
    }

    public function it_throws_an_exception_if_given_non_filter_obj(\stdClass $obj, $distance_filter1, $distance_filter2)
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetFilters([$obj, $distance_filter1, $distance_filter2]);
    }

    public function it_can_work_without_any_filters(Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $this->shouldNotThrow('\InvalidArgumentException')->duringSetFilters([]);


        $this->process()->shouldReturn([
            $activity1, $activity2, $activity3
        ]);
    }

    function it_can_filter_activities_with_one_filter(DistanceFilter $distance_filter1, Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $distance_filter1->setOptions([
            'distance' => 100,
            'operator' => '>',
        ]);

        $this->setFilters([
            $distance_filter1,
        ]);

        $distance_filter1->filter([
            $activity1, $activity2, $activity3
        ])->willReturn(
            [$activity1, $activity2]
        );

        $this->process()->shouldReturn([
            $activity1, $activity2
        ]);
    }

    function it_can_filter_activities_with_multiple_filters(DistanceFilter $distance_filter1, DistanceFilter $distance_filter2, Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $distance_filter1->setOptions([
            'distance' => 100,
            'operator' => '>',
        ]);

        $distance_filter2->setOptions([
            'distance' => 8000,
            'operator' => '<',
        ]);

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

        $this->process()->shouldReturn([
            $activity1
        ]);
    }
}
