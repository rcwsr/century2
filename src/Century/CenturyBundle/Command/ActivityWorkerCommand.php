<?php


namespace Century\CenturyBundle\Command;


use Century\CenturyBundle\Consumer\ConsumerInterface;
use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Filter\DistanceFilter;
use Century\CenturyBundle\Processor\ActivityProcessor;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vivait\WorkerCommandBundle\Command\WorkerCommand;

class ActivityWorkerCommand extends WorkerCommand
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
     * @param ActivityProcessor $processor
     * @param ObjectManager $objectManager
     */
    public function __construct(ConsumerInterface $consumer, ActivityProcessor $processor, ObjectManager $objectManager)
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
        return "century:worker:activities";
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
        $data = json_decode($payload);

        $userRepo = $this->objectManager->getRepository('CenturyCenturyBundle:User');
        $activityRepo = $this->objectManager->getRepository('CenturyCenturyBundle:Activity');
        $user = $userRepo->find($data->user);

        if (!$user) {
            throw new EntityNotFoundException(sprintf('Could not find user by ID: "%s"', $data->user));
        }

        $existingActivities = $activityRepo->findBy(['user.id' => $user->getInternalId()]);

        //Gets all activities for a certain date period
        $activities = $this->consumer->getActivities(
            $data->token,
            \DateTime::createFromFormat('U', $data->from),
            \DateTime::createFromFormat('U', $data->to),
            $user
        );

        $output->writeln(sprintf("Processing %d activities against %d existing activities", count($activities), count($existingActivities)));

        $activities = $this->processor
            ->process($existingActivities, $activities);

        $output->writeln("Finished: " . count($activities) . " saved");
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