<?php

namespace spec\Century\CenturyBundle\Consumer;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use JMS\Serializer\Serializer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\SecurityContextInterface;

class StravaConsumerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Consumer\StravaConsumer');
    }

    public function let(Client $guzzle, Serializer $serializer)
    {
        $this->beConstructedWith($guzzle, $serializer);
    }
}
