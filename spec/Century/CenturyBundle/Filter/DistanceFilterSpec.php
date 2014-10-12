<?php

namespace spec\Century\CenturyBundle\Filter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistanceFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Filter\DistanceFilter');
    }

    function let()
    {
        $this->setActivities([
            ['distance' => '5000'],
            ['distance' => '8000'],
            ['distance' => '100'],
        ]);
    }

    function it_filters_based_on_distance()
    {
        $this->setOptions(['distance' => 5000, 'operator' => '>']);

        $this->filter()->shouldReturn([
            ['distance' => '8000'],
        ]);

        $this->setOptions(['distance' => 10000, 'operator' => '<']);

        $this->filter()->shouldReturn([
            ['distance' => '5000'],
            ['distance' => '8000'],
            ['distance' => '100'],
        ]);

        $this->setOptions(['distance' => 100, 'operator' => '>=']);

        $this->filter()->shouldReturn([
            ['distance' => '5000'],
            ['distance' => '8000'],
            ['distance' => '100'],
        ]);

        $this->setOptions(['distance' => 5000, 'operator' => '<=']);

        $this->filter()->shouldReturn([
            ['distance' => '5000'],
            ['distance' => '100'],
        ]);
    }

    function it_throws_an_exception_for_unknown_operators()
    {
        $this->setOptions(['distance' => 1000, 'operator' => '*']);
        $this->shouldThrow('\InvalidArgumentException')->duringFilter();
    }
}
