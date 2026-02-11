<?php

namespace App\Domain\Task\EventSourcing\Events;

interface TaskEventInterface
{
    public function getNameOfEvent(): string;
    public function toPayload(): array;
}
