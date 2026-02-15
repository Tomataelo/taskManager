<?php

namespace App\Application\Command\Task;

use App\Domain\Task\TaskStatus;

readonly class TaskStatusUpdateCommand
{
    public function __construct(
        public int $taskId,
        private TaskStatus $status
    ){}

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }
}
