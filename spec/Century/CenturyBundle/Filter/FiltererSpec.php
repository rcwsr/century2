<?php

namespace spec\Century\CenturyBundle\Filter;

use Century\CenturyBundle\Filter\DistanceFilter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FiltererSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Filter\Filterer');
    }

    public function let(DistanceFilter $distance_filter1, DistanceFilter $distance_filter2)
    {
        $distance_filter1->setOptions([]);
        $distance_filter1->filter([])->willReturn([]);
        $distance_filter2->setOptions([]);
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

    public function it_can_work_without_any_filters()
    {
        $this->shouldNotThrow('\InvalidArgumentException')->duringSetFilters([]);
        $this->performFilters([
            ['distance' => 1000],
            ['distance' => 2000],
            ['distance' => 3000],
        ])->shouldReturn([
            ['distance' => 1000],
            ['distance' => 2000],
            ['distance' => 3000],
        ]);
    }

    function it_returns_an_array_of_rides()
    {
        $this->performFilters([])->shouldReturn([]);
    }
}
