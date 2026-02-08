<?php

namespace App\Domain\User\Service;

use App\Application\Dto\User\UserDto;
use App\Domain\User\Entity\User;
use App\Infrastructure\Repository\UserRepository;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private AddressService $addressService,
        private CompanyService $companyService
    ){}

    public function createUser(UserDto $userDto): UserDto|false
    {
        $wasFound = $this->userRepository->findOneByUsername($userDto->getUsername());
        if ($wasFound) {
            return false;
        }

        $newUser = new User();
        $newUser->setName($userDto->getName());
        $newUser->setUsername($userDto->getUsername());
        $newUser->setPassword($this->generateRandomPassword());
        $newUser->setEmail($userDto->getEmail());
        $newUser->setPhone($userDto->getPhone());
        $newUser->setWebsite($userDto->getWebsite());
        $newUser->setRoles([$userDto->getRole()]);

        $this->userRepository->save($newUser);

        $this->addressService->createAddress($newUser, $userDto->getAddress());
        $this->companyService->createCompany($newUser, $userDto->getCompany());

        return $userDto;
    }

    private function generateRandomPassword(): string
    {
        return bin2hex(random_bytes(16));
    }

    public function getUserByUsername(string $username): UserDto
    {
        $user = $this->userRepository->findOneByUsername($username);
        if (!$user) {
            throw new ResourceNotFoundException();
        }

        return new UserDto(
            $user->getName(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getWebsite(),
            $user->getCompanies(),
            $user->getRoles()
        );
    }
}
