<?php

namespace Century\CenturyBundle\Command;

use Century\CenturyBundle\Consumer\ConsumerInterface;
use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Filter\DistanceFilter;
use Century\CenturyBundle\Processor\ActivityProcessor;
use Century\CenturyBundle\Processor\ClubProcessor;
use Century\CenturyBundle\Processor\ProcessorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vivait\WorkerCommandBundle\Command\WorkerCommand;

class UserClubWorkerCommand extends WorkerCommand
{
    /**
     * @var ConsumerInterface
     */
    private $consumer;
    /**
     * @var ActivityProcessor
     */
    private $processor;
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @param ConsumerInterface $consumer
     * @param ClubProcessor $processor
     * @param ObjectManager $objectManager
     */
    public function __construct(ConsumerInterface $consumer, ClubProcessor $processor, ObjectManager $objectManager)
    {
        parent::__construct(null);
        $this->consumer = $consumer;
        $this->processor = $processor;
        $this->objectManager = $objectManager;
    }

    /**
     * Set the namespace of the command, e.g. vivait:queue:worker:email
     *
     * @return string
     */
    protected function setCommandNamespace()
    {
        return "century:worker:clubs:user";
    }

    /**
     * Set any extra arguments for the worker. This does not include the tube or ignore arguments required by
     * beanstalk.
     *
     * @return array|null
     */
    protected function setArguments()
    {
    }

    /**
     * @param $payload
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
     * @throws EntityNotFoundException
     */
    protected function performAction($payload, InputInterface $input, OutputInterface $output)
    {
        $data = \GuzzleHttp\json_decode($payload);

        $user_repo = $this->objectManager->getRepository('CenturyCenturyBundle:User');

        $user = $user_repo->find($data->user);

        if (!$user) {
            throw new EntityNotFoundException(sprintf('Could not find user by ID: "%s"', $data->user));
        }

        $existing_clubs = $user->getClubs()->toArray();

        $clubs = $this->consumer->getClubs($data->token);

        $output->writeln(sprintf("Processing %d clubs against %d existing clubs", count($clubs), count($existing_clubs)));

        $this->processor->setUser($user);
        $clubs = $this->processor->process($existing_clubs, $clubs);

        $output->writeln("Finished: " . count($clubs) . "clubs saved");
    }

    /**
     * @param \Exception $e
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function handleException(\Exception $e, InputInterface $input, OutputInterface $output)
    {
        $output->writeln($e->getMessage());
    }
}