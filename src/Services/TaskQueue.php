<?php
namespace App\Services;

use App\Entity\Task;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PessimisticLockException;

class TaskQueue
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTask(): ?Task {
        $this->em->beginTransaction();
        $task = $this->em->getRepository(Task::class)->findOneBy(
            ['status' => Task::STATUS_NEW]
        );

        if(is_null($task)){
            return null;
        }

        /** @var Task $task */

        try {
            $this->em->lock($task, LockMode::PESSIMISTIC_READ);
        }
        catch (PessimisticLockException $e) {
            //Other worker use this task, so get other task
            return $this->getTask();
        }

        $task->setStatus(Task::STATUS_PROCESSING);

        $this->em->persist($task);
        $this->em->flush();
        $this->em->commit();

        return $task;
    }

    public function completeTask(Task $task): void{
        $task->setStatus(TASK::STATUS_DONE);

        $this->em->persist($task);
        $this->em->flush();
    }

    public function errorTask(Task $task): void{
        $task->setStatus(TASK::STATUS_ERROR);

        $this->em->persist($task);
        $this->em->flush();
    }
}
