<?php

namespace App\Infrastructure\ApiClient\Implementation;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class JsonPlaceholderImpl implements ApiInterface
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
