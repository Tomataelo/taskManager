<?php

namespace App\Application\Dto\User;

class GeoDto
{
    public function __construct(
        private string $lat,
        private string $lng
    ) {}

    public function getLat(): string
    {
        return $this->lat;
    }

    public function getLng(): string
    {
        return $this->lng;
    }
}
