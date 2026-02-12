<?php

namespace App\Domain\Task\EventSourcing\Events;

use App\Application\Dto\Task\TaskDto;
use App\Domain\Task\TaskStatus;

class EventFactory
{
    public function created(TaskDto $task, int $userId): TaskCreatedEvent
    {
        return new TaskCreatedEvent($task->getName(), $task->getDescription(), $task->getStatus(), $userId);
    }

    public function statusChanged(int $taskId, TaskStatus $status): TaskStatusUpdatedEvent
    {
        return new TaskStatusUpdatedEvent($taskId, $status);
    }
}
