<?php

namespace App\Domain\Task\EventSourcing\Handlers;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\EventSourcing\Events\TaskCreatedEvent;
use App\Infrastructure\Repository\Task\TaskRepository;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class TaskCreatedHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private TaskRepository $taskRepository,
    ){}

    public function __invoke(TaskCreatedEvent $event): void
    {
        $newTask = new Task();
        $newTask->setName($event->getName());
        $newTask->setDescription($event->getDescription());
        $newTask->setStatus($event->getStatus());
        $newTask->setUser($this->userRepository->find($event->getUserId()));

        $this->taskRepository->save($newTask);
    }
}
