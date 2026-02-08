<?php

namespace App\Domain\User\Service;

use App\Application\Dto\User\CompanyDto;
use App\Domain\User\Entity\Company;
use App\Domain\User\Entity\User;
use App\Infrastructure\Repository\CompanyRepository;

readonly class CompanyService
{
    public function __construct(
        private CompanyRepository $userRepository,
    ){}
    public function createCompany(User $user, CompanyDto $companyDto): void
    {
        $newCompany = new Company();
        $newCompany->setName($companyDto->getName());
        $newCompany->setCatchPhrase($companyDto->getCatchPhrase());
        $newCompany->setBs($companyDto->getBs());
        $newCompany->setUser($user);

        $this->userRepository->save($newCompany);
    }
}
