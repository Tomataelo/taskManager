<?php

namespace App\Domain\Task\EventSourcing\Events;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\TaskStatus;
use DateTimeImmutable;

class EventFactory
{
    public function created(string $name, string $description, TaskStatus $status, int $userId): TaskCreatedEvent
    {
        return new TaskCreatedEvent($name, $description, $status, $userId, new DateTimeImmutable());
    }

    public function statusChanged(int $taskId, TaskStatus $status): TaskStatusUpdatedEvent
    {
        return new TaskStatusUpdatedEvent($taskId, $status, new DateTimeImmutable());
    }
}
