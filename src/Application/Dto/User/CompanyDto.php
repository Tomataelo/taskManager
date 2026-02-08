<?php

namespace App\Application\Dto\User;

class CompanyDto
{
    public function __construct(
        private string $name,
        private string $catchPhrase,
        private string $bs
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }

    public function getBs(): string
    {
        return $this->bs;
    }
}
