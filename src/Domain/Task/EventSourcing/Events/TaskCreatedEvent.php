<?php

namespace App\Domain\Task\EventSourcing\Events;

use App\Domain\Task\TaskStatus;
use DateTimeImmutable;

readonly class TaskCreatedEvent implements TaskEventInterface
{
    public function __construct(
        private string            $name,
        private string            $description,
        private TaskStatus        $status,
        private int               $userId,
        private DateTimeImmutable $createdAt
    ) {}

    public function getNameOfEvent(): string
    {
        return 'TaskCreatedEvent';
    }

    public function toPayload(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
            'userId' => $this->userId,
            'createdAt' => $this->createdAt->format(DATE_ATOM),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
