<?php

namespace App\Application\Controllers;

use App\Domain\User\Provider\UserImportProvider;
use App\Domain\User\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('api/user')]
class UserController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     */

    #[Route('/import-users', methods: ['POST'])]
    public function importUsers(UserImportProvider $userImportProvider): JsonResponse
    {
        $importedUsers = $userImportProvider->importUsers();

        return new JsonResponse($importedUsers);
    }

    #[Route('/security/about-me', methods: ['GET'])]
    public function aboutMe(UserService $userService): JsonResponse
    {
        try {
            $user = $userService->getUserByUsername($this->getUser()->getUserIdentifier());
        } catch (ResourceNotFoundException $e) {
            return $this->json([$e->getMessage()]);
        }

        return new JsonResponse($user);
    }
}
