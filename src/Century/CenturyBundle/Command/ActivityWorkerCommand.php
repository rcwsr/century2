<?php


namespace Century\CenturyBundle\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vivait\WorkerCommandBundle\Command\WorkerCommand;

class ActivityWorkerCommand extends WorkerCommand{

    /**
     * Set the namespace of the command, e.g. vivait:queue:worker:email
     *
     * @return string
     */
    protected function setCommandNamespace()
    {
        // TODO: Implement setCommandNamespace() method.
    }

    /**
     * Set any extra arguments for the worker. This does not include the tube or ignore arguments required by
     * beanstalk.
     *
     * @return array|null
     */
    protected function setArguments()
    {
        // TODO: Implement setArguments() method.
    }

    /**
     * @param $payload
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function performAction($payload, InputInterface $input, OutputInterface $output)
    {

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