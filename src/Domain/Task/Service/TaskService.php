<?php

namespace App\Domain\Task\Service;

use App\Application\Dto\Task\TaskDto;
use App\Domain\Task\EventSourcing\Events\EventFactory;
use App\Domain\Task\EventSourcing\EventService;
use App\Domain\Task\TaskStatus;
use App\Domain\User\Service\UserService;
use App\Infrastructure\Repository\Task\TaskRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function __construct(
        private UserService $userService,
        private EventFactory $eventFactory,
        private EventService $eventService,
        private TaskRepository $taskRepository,
    ){}

    public function create(TaskDTO $taskDTO, string $username): TaskDto
    {
        $user = $this->userService->getUserByUsername($username, true);
        $event = $this->eventFactory->created($taskDTO, $user->getId());

        $this->eventService->execute($event);

        return $taskDTO;
    }

    public function changeStatus(int $id, \stdClass $status): void
    {
        $taskEntity = $this->taskRepository->findOneById($id)
            ?? throw new NotFoundHttpException('Task not found');

        try {
            $taskStatus = TaskStatus::from($status->status);
        } catch (\ValueError $e) {
            throw new NotFoundHttpException('Task status not found');
        }

        $event = $this->eventFactory->statusChanged($taskEntity->getId(), $taskStatus);

        $this->eventService->execute($event);
    }

    public function getAllTasksFromUser(string $username): Collection
    {
        $user = $this->userService->getUserByUsername($username, true);
        return $user->getTasks();
    }

    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }
}
