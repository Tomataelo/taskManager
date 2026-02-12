<?php

namespace App\Infrastructure\ApiClient\Implementation;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiInterface
{
    public function get(string $endpoint): ResponseInterface;
}
