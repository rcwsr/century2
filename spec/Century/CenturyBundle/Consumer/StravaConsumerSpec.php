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


    public function let(Client $guzzle)
    {
        $this->beConstructedWith($guzzle);
    }

    function it_can_get_all_activities_before_a_date(Client $guzzle)
    {
        $from = \DateTime::createFromFormat('U', time());
        $to = \DateTime::createFromFormat('U', time());
        $guzzle->get(Argument::any(), Argument::any())->willReturn(
            [
                ['id' => '1'],
                ['id' => '2'],
            ]
            );


        $this->getActivities(Argument::any(), $from, $to);
    }


}
