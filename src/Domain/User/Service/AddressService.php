<?php

namespace App\Domain\User\Service;

use App\Application\Dto\User\AddressDto;
use App\Domain\User\Entity\Address;
use App\Domain\User\Entity\User;
use App\Infrastructure\Repository\User\AddressRepository;

readonly class AddressService
{
    public function __construct(
        private AddressRepository $addressRepository,
        private GeoService        $geoService,
    ){}
    public function createAddress(User $user, AddressDto $addressDto): void
    {
        $newAddress = new Address();
        $newAddress->setStreet($addressDto->getStreet());
        $newAddress->setSuite($addressDto->getSuite());
        $newAddress->setCity($addressDto->getCity());
        $newAddress->setZipcode($addressDto->getZipcode());
        $newAddress->setUser($user);

        $this->addressRepository->save($newAddress);

        $this->geoService->createGeo($newAddress, $addressDto->getGeo());
    }
}
