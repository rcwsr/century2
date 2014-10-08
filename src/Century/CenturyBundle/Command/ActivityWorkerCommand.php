<?php


namespace Century\CenturyBundle\Command;


use Century\CenturyBundle\Consumer\ConsumerInterface;
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
     * @param ConsumerInterface $consumer
     */
    public function __construct(ConsumerInterface $consumer)
    {
        parent::__construct(null);
        $this->consumer = $consumer;
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

        $rides = $this->consumer->getActivities($data->token, $from, $to);

        $output->writeln(count($rides));
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