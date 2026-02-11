<?php

namespace App\Domain\Task\EventSourcing\Events;

use App\Domain\Task\TaskStatus;
use DateTimeImmutable;

readonly class TaskStatusUpdatedEvent implements TaskEventInterface
{
    public function __construct(
        private int               $taskId,
        private TaskStatus        $status,
        private DateTimeImmutable $createdAt
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
            'createdAt' => $this->createdAt->format(DATE_ATOM),
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
