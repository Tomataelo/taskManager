<?php

namespace App\Tests;

use App\Application\Command\Task\TaskCreateCommand;
use App\Application\Command\Task\TaskStatusUpdateCommand;
use App\Domain\Task\EventSourcing\Events\Factory\TaskEventFactory;
use App\Domain\Task\EventSourcing\Events\TaskCreatedEvent;
use App\Domain\Task\EventSourcing\Events\TaskStatusUpdatedEvent;
use App\Domain\Task\TaskStatus;
use PHPUnit\Framework\TestCase;

class TaskEventFactoryTest extends TestCase
{
    public function testCreateTaskCreatedEvent(): void
    {
        $taskCreateCommand = $this->createMock(TaskCreateCommand::class);
        $taskCreateCommand->method('getName')->willReturn('taskCreate');
        $taskCreateCommand->method('getDescription')->willReturn('taskCreateDescription');
        $taskCreateCommand->method('getStatus')->willReturn(TaskStatus::TO_DO);
        $taskCreateCommand->method('getUserId')->willReturn(1);

        $factory = new TaskEventFactory();
        $event = $factory->createEvent($taskCreateCommand);

        $this->assertInstanceOf(TaskCreatedEvent::class, $event);

        $this->assertEquals('taskCreate', $event->getName());
        $this->assertEquals('taskCreateDescription', $event->getDescription());
        $this->assertEquals(TaskStatus::TO_DO, $event->getStatus());
        $this->assertEquals(1, $event->getUserId());
    }

    public function testCreateTaskStatusUpdatedEvent(): void
    {
        $taskStatusUpdateCommand = $this->createMock(TaskStatusUpdateCommand::class);
        $taskStatusUpdateCommand->method('getTaskId')->willReturn(997);
        $taskStatusUpdateCommand->method('getStatus')->willReturn(TaskStatus::IN_PROGRESS);

        $factory = new TaskEventFactory();
        $event = $factory->createEvent($taskStatusUpdateCommand);

        $this->assertInstanceOf(TaskStatusUpdatedEvent::class, $event);

        $this->assertEquals(997, $event->getTaskId());
        $this->assertEquals(TaskStatus::IN_PROGRESS, $event->getStatus());
    }

    public function test()
    {
        $unkownCommand = $this->createMock(\stdClass::class);

        $factory = new TaskEventFactory();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown command type');

        $factory->createEvent($unkownCommand);
    }
}
