<?php

namespace App\Domain\User\Provider;

use App\Application\Dto\User\UserDto;
use App\Domain\User\Service\UserService;
use App\Infrastructure\ApiClient\UserApiPlaceholderProvider;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class UserImportProvider
{
    public function __construct(
        private UserApiPlaceholderProvider $apiProvider,
        private UserService                $userService,
        private SerializerInterface         $serializer,
    ){}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     * @throws DecodingExceptionInterface
     */

    // tutaj pomyśleć o fabryce ale nwm

    public function importUsers(): array
    {
        $usersFromApi = $this->apiProvider->getUsers();

        $createdUsers = [];
        foreach ($usersFromApi as $user) {
            $userDto = $this->serializer->deserialize(json_encode($user), UserDto::class, 'json');

            $createdUser = $this->userService->createUser($userDto);
            if ($createdUser) {
                $createdUsers[] = $createdUser;
            }
        }

        return $createdUsers;
    }
}
