<?php

namespace App\Infrastructure\ApiClient;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    private const BASE_URL = 'https://jsonplaceholder.typicode.com/';

    public function __construct(
        private readonly HttpClientInterface $client
    ){}

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $endpoint): ResponseInterface
    {
        return $this->client->request('GET', self::BASE_URL . $endpoint);
    }
}
