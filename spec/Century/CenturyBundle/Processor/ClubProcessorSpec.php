<?php

namespace spec\Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Document\Club;
use Century\CenturyBundle\Document\User;
use Century\CenturyBundle\Filter\DistanceFilter;
use Century\CenturyBundle\Sync\SynchronizerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClubProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Century\CenturyBundle\Processor\ClubProcessor');
    }

    public function let(ObjectRepository $repo, SynchronizerInterface $sync, ObjectManager $objectManager, User $user, Club $club1, Club $club2)
    {
        $this->beConstructedWith($sync, $objectManager);
        $objectManager->getRepository(Argument::any())->willReturn($repo);

        $club1->__toString()->willReturn('Leicester Forest A');
        $club1->getInternalId()->willReturn(1);

        $club2->__toString()->willReturn('Leicester Road Club B');
        $club2->getInternalId()->willReturn(2);

        $this->setUser($user);
    }

    public function it_doesnt_create_duplicate_clubs(ObjectManager $objectManager, ObjectRepository $repo, SynchronizerInterface $sync, Club $club1, Club $club2, Club $new_club1, Club $processed_club1, Club $processed_club2)
    {
        $existing_clubs = [$club1, $club2];
        $repo->findAll()->willReturn($existing_clubs);

        $objectManager->flush()->shouldBeCalled();

        $new_club1->__toString()->willReturn('Leicester Road Club B');
        $newly_joined_clubs = [$new_club1];

        $user_clubs = [$club1];

        $sync->sync($user_clubs, $newly_joined_clubs)->willReturn($newly_joined_clubs);
        $sync->getTrash()->willReturn([]);

        $new_club1->equals($club1)->willReturn(false);
        $new_club1->equals($club2)->willReturn(true);

        $new_club1->setInternalId(2)->shouldBeCalled();

        $processed_club1->__toString()->willReturn('Leicester Road Club B');
        $processed_club1->getInternalId()->willReturn(2);

        $processed_clubs = [$processed_club1];
        $this->process($user_clubs, $newly_joined_clubs)->shouldReturn($processed_clubs);
    }

    public function it_can_update_club_details(){

    }
}
