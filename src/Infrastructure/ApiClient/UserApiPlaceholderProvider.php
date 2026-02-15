<?php

namespace App\Infrastructure\ApiClient;

use App\Infrastructure\ApiClient\Implementation\ApiInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class UserApiPlaceholderProvider
{
    public function __construct(
        private ApiInterface $apiClient
    ){}

    public function getUsers(): array
    {
        return $this->apiClient->get('users')->toArray();
    }
}
