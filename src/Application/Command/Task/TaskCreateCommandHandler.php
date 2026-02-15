<?php

namespace App\Application\Command\Task;

use App\Domain\Task\EventSourcing\Events\Factory\EventFactory;
use App\Domain\Task\EventSourcing\EventService;
use App\Domain\User\Service\UserService;

readonly class TaskCreateCommandHandler
{
    public function __construct(
        private EventFactory $eventFactory,
        private EventService $eventService,
        private UserService $userService
    ){}

    public function create(TaskCreateCommand $taskCreateCommand)
    {
        $user = $this->userService->getUserByUsername($taskCreateCommand->getUsername(), true);
        $taskCreateCommand->setUserId($user->getId());

        $event = $this->eventFactory->createEvent($taskCreateCommand);
        $this->eventService->execute($event);
    }
}
