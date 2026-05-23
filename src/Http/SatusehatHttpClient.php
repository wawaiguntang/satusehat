<?php

namespace Wawaiguntang\Satusehat\Http;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Wawaiguntang\Satusehat\Auth\SatusehatAuthenticator;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ForbiddenException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ServerException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;

class SatusehatHttpClient
{
    public function __construct(
        private readonly string                  $baseUrl,
        private readonly ClientInterface         $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface  $streamFactory,
        private readonly SatusehatAuthenticator  $authenticator,
        private readonly int                     $maxRetries     = 3,
        private readonly int                     $retryDelayMs   = 100,
    ) {}

    public function get(string $path, array $queryParams = []): array
    {
        $url = $this->buildUrl($path, $queryParams);

        $request = $this->requestFactory
            ->createRequest('GET', $url)
            ->withHeader('Authorization', 'Bearer ' . $this->authenticator->getToken())
            ->withHeader('Content-Type', 'application/json');

        return $this->send($request);
    }

    public function post(string $path, array $body): array
    {
        $stream  = $this->streamFactory->createStream(json_encode($body));
        $request = $this->requestFactory
            ->createRequest('POST', $this->baseUrl . $path)
            ->withHeader('Authorization', 'Bearer ' . $this->authenticator->getToken())
            ->withHeader('Content-Type', 'application/json')
            ->withBody($stream);

        return $this->send($request);
    }

    public function put(string $path, array $body): array
    {
        $stream  = $this->streamFactory->createStream(json_encode($body));
        $request = $this->requestFactory
            ->createRequest('PUT', $this->baseUrl . $path)
            ->withHeader('Authorization', 'Bearer ' . $this->authenticator->getToken())
            ->withHeader('Content-Type', 'application/json')
            ->withBody($stream);

        return $this->send($request);
    }

    public function patch(string $path, array $operations): array
    {
        $stream  = $this->streamFactory->createStream(json_encode($operations));
        $request = $this->requestFactory
            ->createRequest('PATCH', $this->baseUrl . $path)
            ->withHeader('Authorization', 'Bearer ' . $this->authenticator->getToken())
            ->withHeader('Content-Type', 'application/json-patch+json')
            ->withBody($stream);

        return $this->send($request);
    }

    private function buildUrl(string $path, array $queryParams = []): string
    {
        $url = $this->baseUrl . $path;
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        return $url;
    }

    private function send(\Psr\Http\Message\RequestInterface $request): array
    {
        $attempt = 0;

        do {
            $response   = $this->httpClient->sendRequest($request);
            $statusCode = $response->getStatusCode();
            $rawBody    = (string) $response->getBody();

            if ($statusCode >= 200 && $statusCode < 300) {
                return json_decode($rawBody, true) ?? [];
            }

            if ($statusCode >= 500 && $attempt < $this->maxRetries - 1) {
                $attempt++;
                usleep($this->retryDelayMs * (2 ** ($attempt - 1)) * 1000);
                continue;
            }

            $this->throwForStatus($statusCode, $rawBody);
        } while (true);
    }

    private function throwForStatus(int $statusCode, string $body): never
    {
        throw match (true) {
            $statusCode === 400               => ValidationException::fromResponseBody($statusCode, $body),
            $statusCode === 401               => AuthenticationException::fromResponseBody($statusCode, $body),
            $statusCode === 403               => ForbiddenException::fromResponseBody($statusCode, $body),
            $statusCode === 404               => ResourceNotFoundException::fromResponseBody($statusCode, $body),
            $statusCode >= 500                => ServerException::fromResponseBody($statusCode, $body),
            default                           => SatusehatException::fromResponseBody($statusCode, $body),
        };
    }
}
