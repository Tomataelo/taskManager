<?php

namespace App\Domain\Task\EventSourcing\Events;

use App\Domain\Task\TaskStatus;

readonly class TaskStatusUpdatedEvent implements TaskEventInterface
{
    public function __construct(
        private int               $taskId,
        private TaskStatus        $status,
    ) {}

    public function getNameOfEvent(): string
    {
        return 'TaskStatusUpdatedEvent';
    }

    public function toPayload(): array
    {
        return [
            'taskId' => $this->taskId,
            'status' => $this->status->value,
        ];
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }
}
