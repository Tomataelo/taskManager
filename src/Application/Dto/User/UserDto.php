<?php

namespace App\Application\Dto\User;

use Doctrine\Common\Collections\Collection;

class UserDto
{
    public function __construct(
        private string $name,
        private string $username,
        private string $email,
        private AddressDto|Collection $address,
        private string $phone,
        private string $website,
        private CompanyDto|Collection $company,
        private array $role = ["ROLE_USER"],
    ) {}

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): void
    {
        $this->role = $role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): AddressDto|Collection
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getCompany(): CompanyDto|Collection
    {
        return $this->company;
    }
}
