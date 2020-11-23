<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Worker
{
    private TaskQueue $taskQueue;

    private HttpChecker $httpChecker;

    public function __construct(TaskQueue $queue, HttpChecker $httpChecker)
    {
        $this->taskQueue = $queue;
        $this->httpChecker = $httpChecker;
    }

    public function start(){
        while(true){
            $task = $this->taskQueue->getTask();

            if(is_null($task)){
                //In some cases we should wait new task here
                break;
            }

            try{
                $status = $this->httpChecker->getStatusCode($task->getUrl());
            }
            catch (TransportExceptionInterface $e) {
                $this->taskQueue->errorTask($task);
                continue;
            }
            $task->setHttpCode($status);
            $this->taskQueue->completeTask($task);
        }
    }
}
