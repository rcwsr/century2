<?php


namespace Century\CenturyBundle\Command;


use Century\CenturyBundle\Consumer\ConsumerInterface;
use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Processor\ActivityProcessor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;
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
     * @var FormTypeInterface
     */
    private $form;
    /**
     * @var FormFactoryInterface
     */
    private $factory;


    /**
     * @param ConsumerInterface $consumer
     * @param ActivityProcessor $processor
     * @param FormTypeInterface $form
     * @param FormFactoryInterface $factory
     */
    public function __construct(ConsumerInterface $consumer, ActivityProcessor $processor, FormTypeInterface $form, FormFactoryInterface $factory)
    {
        parent::__construct(null);
        $this->consumer = $consumer;
        $this->processor = $processor;
        $this->form = $form;
        $this->factory = $factory;
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
     * @return mixed
     */
    protected function performAction($payload, InputInterface $input, OutputInterface $output)
    {
        $data = \GuzzleHttp\json_decode($payload);

        $from = \DateTime::createFromFormat('U', $data->from);
        $to = \DateTime::createFromFormat('U', $data->to);

        $raw_activities = $this->consumer->getActivities($data->token, $from, $to);
        $activities = [];
        foreach($raw_activities as $raw_activity){
            $activity = new Activity();
            $form = $this->factory->create($this->form, $raw_activity);

            if($form->isValid())
                $activities[] = $activity;
        }

        $this->processor->process($activities);
    }

    /**
     * @param \Exception $e
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function handleException(\Exception $e, InputInterface $input, OutputInterface $output)
    {
        // TODO: Implement handleException() method.
    }
}