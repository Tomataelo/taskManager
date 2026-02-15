<?php

namespace App\Application\Command\Task;

use App\Domain\Task\EventSourcing\Events\Factory\EventFactory;
use App\Domain\Task\EventSourcing\EventService;
use App\Infrastructure\Repository\Task\TaskRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class TaskStatusUpdateCommandHandler
{
    public function __construct(
        private EventFactory $eventFactory,
        private EventService $eventService,
        private TaskRepository $taskRepository,
    ){}

    public function changeStatus(TaskStatusUpdateCommand $taskStatusUpdateCommand): void
    {
        $this->taskRepository->findOneById($taskStatusUpdateCommand->getTaskId())
            ?? throw new NotFoundHttpException('Task not found');

        $event = $this->eventFactory->createEvent($taskStatusUpdateCommand);

        $this->eventService->execute($event);
    }
}
