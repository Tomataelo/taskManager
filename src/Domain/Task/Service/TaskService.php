<?php

namespace App\Domain\Task\Service;

use App\Domain\User\Service\UserService;
use App\Infrastructure\Repository\Task\TaskRepository;
use Doctrine\Common\Collections\Collection;

readonly class TaskService
{
    public function __construct(
        private UserService $userService,
        private TaskRepository $taskRepository,
    ){}

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
