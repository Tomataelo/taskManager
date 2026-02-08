<?php

namespace App\Domain\User\Entity;

use App\Infrastructure\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $catch_phrase = null;

    #[ORM\Column(length: 255)]
    private ?string $bs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCatchPhrase(): ?string
    {
        return $this->catch_phrase;
    }

    public function setCatchPhrase(string $catch_phrase): static
    {
        $this->catch_phrase = $catch_phrase;

        return $this;
    }

    public function getBs(): ?string
    {
        return $this->bs;
    }

    public function setBs(string $bs): static
    {
        $this->bs = $bs;

        return $this;
    }
}
