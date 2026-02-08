<?php

namespace App\Domain\User\Service;

use App\Application\Dto\User\GeoDto;
use App\Domain\User\Entity\Address;
use App\Domain\User\Entity\Geo;
use App\Infrastructure\Repository\GeoRepository;

class GeoService
{
    public function __construct(
        private readonly GeoRepository $geoRepository
    ){}
    public function createGeo(Address $address, GeoDto $geoDto): void
    {
        $newGeo = new Geo();
        $newGeo->setLat($geoDto->getLat());
        $newGeo->setLng($geoDto->getLng());
        $newGeo->setAddress($address);

        $this->geoRepository->save($newGeo);
    }
}
