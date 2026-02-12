<?php

namespace App\Domain\Task\EventSourcing;

use App\Domain\Task\Entity\EventStore;
use App\Domain\Task\EventSourcing\Events\TaskEventInterface;
use App\Infrastructure\EventStore\EventStoreRepository;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class EventService
{
    public function __construct(
        private EventStoreRepository $eventStoreRepository,
        private MessageBusInterface  $messageBus
    ){}

    /**
     * @throws ExceptionInterface
     */
    public function execute(TaskEventInterface $event): void
    {
        $newEventStore = new EventStore();
        $newEventStore->setEventType($event->getNameOfEvent());
        $newEventStore->setPayload($event->toPayload());
        $this->eventStoreRepository->save($newEventStore);

        $this->messageBus->dispatch($event);
    }
}
