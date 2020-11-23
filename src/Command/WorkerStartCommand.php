<?php

namespace App\Command;

use App\Services\Worker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WorkerStartCommand extends Command
{
    protected $worker;

    function __construct(Worker $worker)
    {
        parent::__construct('app:worker');

        $this->worker = $worker;
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->worker->start();

        return 0;
    }
}
