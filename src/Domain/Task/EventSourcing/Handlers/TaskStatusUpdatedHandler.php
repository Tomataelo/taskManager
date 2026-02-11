<?php

namespace App\Domain\Task\EventSourcing\Handlers;
use App\Domain\Task\EventSourcing\Events\TaskStatusUpdatedEvent;
use App\Infrastructure\Repository\Task\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class TaskStatusUpdatedHandler
{
    public function __construct(
        private TaskRepository $taskRepository,
    ){}

    public function __invoke(TaskStatusUpdatedEvent $event): void
    {
        $task = $this->taskRepository->find($event->getTaskId());
        $task->setStatus($event->getStatus());

        $this->taskRepository->save($task);
    }
}
