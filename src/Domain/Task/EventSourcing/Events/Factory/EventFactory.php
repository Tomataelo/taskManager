<?php

namespace App\Domain\Task\EventSourcing\Events\Factory;

interface EventFactory
{
    public function createEvent(object $command);
}
