<?php

namespace spec\Century\CenturyBundle\Consumer;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\SecurityContextInterface;

class StravaConsumerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Consumer\StravaConsumer');
    }

    /**
     * @param ClientInterface $guzzle
     * @param SecurityContextInterface $context
     */
    public function let(Client $guzzle, SecurityContextInterface $context)
    {
        $this->beConstructedWith($guzzle, $context);
    }

    function it_can_get_all_activities_before_a_date(Client $guzzle)
    {

    }
}
