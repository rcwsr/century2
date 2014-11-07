<?php

namespace Century\CenturyBundle\Listener;

use Leezy\PheanstalkBundle\Proxy\PheanstalkProxyInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SynchronizeUserClubsListener
{
    /**
     * @var PheanstalkProxyInterface
     */
    private $pheanstalkProxyInterface;

    /**
     * @param PheanstalkProxyInterface $pheanstalkProxyInterface
     */
    public function __construct(PheanstalkProxyInterface $pheanstalkProxyInterface)
    {
        $this->pheanstalkProxyInterface = $pheanstalkProxyInterface;
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        $this->pheanstalkProxyInterface
            ->useTube('century.tube.user.clubs')
            ->put(json_encode([
                'token' => $event->getAuthenticationToken()->getAccessToken(),
                'user' => $event->getAuthenticationToken()->getUser()->getInternalId(),
            ]));
    }
} 