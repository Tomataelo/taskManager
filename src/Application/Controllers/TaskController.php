<?php

namespace App\Application\Controllers;

use App\Application\Dto\Task\TaskDto;
use App\Domain\Task\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

// CO ZROBIĆ JESZCZE!! //

// do wszystkich kontrolerów ładnie bym dodał try catche
// tutaj wszędzie dorobic event sourcing

// END CO ZROBIĆ JESZCZE!! //

#[Route('api/task/security')]
class TaskController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly TaskService         $taskService
    ){}

    /**
     * @throws ExceptionInterface
     */
    #[Route('/', methods: ['POST'])]
    public function createTask(Request $request): JsonResponse
    {
        $taskDTO = $this->serializer->deserialize($request->getContent(), TaskDTO::class, 'json');
        $newTask = $this->taskService->create($taskDTO, $this->getUser()->getUserIdentifier());

        return $this->json($newTask);
    }

    #[Route('/change-status/{id}', methods: ['PUT'])]
    public function changeStatus(int $id, Request $request): JsonResponse
    {
        try {

            $this->taskService->changeStatus($id, json_decode($request->getContent()));

        } catch (NotFoundHttpException $e) {
            return new JsonResponse(["error" => $e->getMessage()], 404);
        } catch (\ValueError $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

        // tutaj sie zastanowic co ma zwracac czy poprostu 1 czy dto
        return new JsonResponse(1, 200);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/my-tasks', methods: ['GET'])]
    public function myTasks(): JsonResponse
    {
        $userTasks = $this->taskService->getAllTasksFromUser($this->getUser()->getUserIdentifier());
        $userTasksJson = $this->serializer->serialize($userTasks, 'json');

        return new JsonResponse($userTasksJson, 200, [], true);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/list-all-tasks', methods: ['GET'])]
    public function getAllTasks(): JsonResponse
    {
        $allTasks = $this->taskService->getAllTasks();
        $allTasksJson = $this->serializer->serialize($allTasks, 'json');

        return new JsonResponse($allTasksJson, 200, [], true);
    }
}
