<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpChecker
{
    public HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $uri
     * @return int
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getStatusCode(string $uri): int{
        $response = $this->httpClient->request("GET", $uri);

        return $response->getStatusCode();
    }
}
