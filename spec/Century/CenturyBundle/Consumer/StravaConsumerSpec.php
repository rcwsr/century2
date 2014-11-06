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
}
