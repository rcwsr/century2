<?php

namespace spec\Century\CenturyBundle\Filter;

use Century\CenturyBundle\Document\Activity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistanceFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Filter\DistanceFilter');
    }

    function let(Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $activity1->getDistance()->willReturn(5000);
        $activity2->getDistance()->willReturn(8000);
        $activity3->getDistance()->willReturn(100);

    }

    function it_filters_based_on_distance(Activity $activity1, Activity $activity2, Activity $activity3)
    {
        $this->setOptions(['distance' => 5000, 'operator' => '>']);

        $this->filter([$activity1, $activity2, $activity3])->shouldReturn([
            $activity2,
        ]);

        $this->setOptions(['distance' => 10000, 'operator' => '<']);

        $this->filter([$activity1, $activity2, $activity3])->shouldReturn([
            $activity1,
            $activity2,
            $activity3,
        ]);

        $this->setOptions(['distance' => 100, 'operator' => '>=']);

        $this->filter([$activity1, $activity2, $activity3])->shouldReturn([
            $activity1,
            $activity2,
            $activity3,
        ]);

        $this->setOptions(['distance' => 5000, 'operator' => '<=']);

        $this->filter([$activity1, $activity2, $activity3])->shouldReturn([
            $activity1,
            $activity3,
        ]);
    }

    function it_throws_an_exception_for_unknown_operators(Activity $activity1, Activity $activity2)
    {
        $this->setOptions(['distance' => 1000, 'operator' => '*']);
        $this->shouldThrow('\InvalidArgumentException')->duringFilter([$activity1, $activity2]);
    }
}
