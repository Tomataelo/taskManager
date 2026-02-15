<?php

namespace App\Application\Controllers;

use App\Application\Command\Task\TaskCreateCommand;
use App\Application\Command\Task\TaskCreateCommandHandler;
use App\Application\Command\Task\TaskStatusUpdateCommand;
use App\Application\Command\Task\TaskStatusUpdateCommandHandler;
use App\Application\Dto\Task\TaskDto;
use App\Domain\Task\Service\EventStoreService;
use App\Domain\Task\Service\TaskService;
use App\Domain\Task\TaskStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/task/security')]
class TaskController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface            $serializer,
        private readonly TaskCreateCommandHandler       $taskCreateCommandHandler,
        private readonly TaskStatusUpdateCommandHandler $taskStatusUpdateCommandHandler,
        private readonly TaskService                    $taskService,
    ){}

    #[Route('/', methods: ['POST'])]
    public function createTask(Request $request): JsonResponse
    {
        $taskDTO = $this->serializer->deserialize($request->getContent(), TaskDTO::class, 'json');

        $taskCreateCommand = new TaskCreateCommand(
            $taskDTO->getName(),
            $taskDTO->getDescription(),
            $taskDTO->getStatus(),
            $this->getUser()->getUserIdentifier()
        );

        $this->taskCreateCommandHandler->create($taskCreateCommand);

        return new JsonResponse(1, 204);
    }

    #[Route('/change-status/{id}', methods: ['PUT'])]
    public function changeStatus(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());
        if (!isset($data->status)) {
            throw new BadRequestHttpException('Missing status field');
        }

        try {

            $taskStatusUpdateCommand = new TaskStatusUpdateCommand(
                $id,
                TaskStatus::from($data->status)
            );

            $this->taskStatusUpdateCommandHandler->changeStatus($taskStatusUpdateCommand);

        } catch (NotFoundHttpException $e) {
            return new JsonResponse(["error" => $e->getMessage()], 404);
        }

        return new JsonResponse(1, 204);
    }

    #[Route('/my-tasks', methods: ['GET'])]
    public function myTasks(): JsonResponse
    {
        $userTasks = $this->taskService->getAllTasksFromUser($this->getUser()->getUserIdentifier());
        $userTasksJson = $this->serializer->serialize($userTasks, 'json');

        return new JsonResponse($userTasksJson, 200, [], true);
    }

    #[Route('/list-all-tasks', methods: ['GET'])]
    public function getAllTasks(): JsonResponse
    {
        $allTasks = $this->taskService->getAllTasks();
        $allTasksJson = $this->serializer->serialize($allTasks, 'json');

        return new JsonResponse($allTasksJson, 200, [], true);
    }

    #[Route('/history/{id}', methods: ['GET'])]
    public function taskHistory(int $id, EventStoreService $eventStoreService): JsonResponse
    {
        return new JsonResponse($eventStoreService->getHistoryOfTask($id));
    }
}
