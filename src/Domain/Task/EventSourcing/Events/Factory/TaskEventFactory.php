<?php

namespace App\Domain\Task\EventSourcing\Events\Factory;

use App\Application\Command\Task\TaskCreateCommand;
use App\Application\Command\Task\TaskStatusUpdateCommand;
use App\Domain\Task\EventSourcing\Events\TaskCreatedEvent;
use App\Domain\Task\EventSourcing\Events\TaskStatusUpdatedEvent;

class TaskEventFactory implements EventFactory
{
    public function createEvent(object $command)
    {
        return match (true) {

            $command instanceof TaskCreateCommand =>
                new TaskCreatedEvent(
                    $command->getName(),
                    $command->getDescription(),
                    $command->getStatus(),
                    $command->getUserId()
                ),

            $command instanceof TaskStatusUpdateCommand =>
                new TaskStatusUpdatedEvent(
                    $command->getTaskId(),
                    $command->getStatus()
                ),

            default => throw new \InvalidArgumentException('Unknown command type'),
        };
    }
}
