<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Entity\EventStore;
use App\Infrastructure\EventStore\EventStoreRepository;

readonly class EventStoreService
{
    public function __construct(
        private EventStoreRepository $eventStoreRepository
    ){}

    public function getHistoryOfTask(int $taskId): array
    {
        $events = $this->eventStoreRepository->findByTaskIdAndEventType($taskId, 'TaskStatusUpdatedEvent');

        return array_map(function (EventStore $e) {
            return [
                'id' => $e->getId(),
                'eventType' => $e->getEventType(),
                'payload' => $e->getPayload(),
                'createdAt' => $e->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $events);
    }
}
