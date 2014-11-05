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
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var ObjectManager
     */
    private $objectManager;


    /**
     * @param ConsumerInterface $consumer
     * @param ActivityProcessor $processor
     * @param ValidatorInterface $validator
     */
    public function __construct(ConsumerInterface $consumer, ActivityProcessor $processor, ValidatorInterface $validator, ObjectManager $objectManager)
    {
        parent::__construct(null);
        $this->consumer = $consumer;
        $this->processor = $processor;
        $this->validator = $validator;
        $this->objectManager = $objectManager;
    }

    /**
     * Set the namespace of the command, e.g. vivait:queue:worker:email
     *
     * @return string
     */
    protected function setCommandNamespace()
    {
        return "century:queue:worker:activities";
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

        $from = \DateTime::createFromFormat('U', $data->from);
        $to = \DateTime::createFromFormat('U', $data->to);

        $user_repo = $this->objectManager->getRepository('CenturyCenturyBundle:User');
        $activity_repo = $this->objectManager->getRepository('CenturyCenturyBundle:Activity');
        $user = $user_repo->find($data->user);

        if (!$user) {
            throw new EntityNotFoundException(sprintf('Could not find user by ID: "%s"', $data->user));
        }

        $existing_activities = $activity_repo->findBy(['user.internal_id' => $user->getInternalId()]);

        //Gets all activities for a certain date period
        $activities = $this->consumer->getActivities($data->token, $from, $to, $user);

        $output->writeln(sprintf("Processing %d activities against %d existing activities", count($activities), count($existing_activities)));

        //Filters activities with provided filters
        $filter = new DistanceFilter();
        $filter->setOptions([
            'distance' => 100000,
            'operator' => '>',
        ]);

        $activities = $this->processor
            ->setFilters($filter)
            ->process($existing_activities, $activities);


        $output->writeln("Finished: " . count($activities));
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