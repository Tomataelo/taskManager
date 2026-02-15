<?php

namespace App\Application\Command\Task;

use App\Domain\Task\TaskStatus;

class TaskCreateCommand
{
    private int $userId;

    public function __construct(
        private readonly string     $name,
        private readonly string     $description,
        private readonly TaskStatus $status,
        private readonly string     $username,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

}
