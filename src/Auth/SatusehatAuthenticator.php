<?php

namespace Wawaiguntang\Satusehat\Auth;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;

class SatusehatAuthenticator
{
    private const CACHE_TTL_BUFFER = 60;

    public function __construct(
        private readonly string                  $clientId,
        private readonly string                  $clientSecret,
        private readonly string                  $authUrl,
        private readonly ClientInterface         $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface  $streamFactory,
        private readonly CacheInterface          $cache,
    ) {}

    public function getToken(): string
    {
        $cacheKey = 'satusehat_token_' . md5($this->clientId);

        $cached = $this->cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        return $this->fetchToken($cacheKey);
    }

    private function fetchToken(string $cacheKey): string
    {
        $body = http_build_query([
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        $stream  = $this->streamFactory->createStream($body);
        $request = $this->requestFactory
            ->createRequest('POST', $this->authUrl . '/accesstoken?grant_type=client_credentials')
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($stream);

        $response   = $this->httpClient->sendRequest($request);
        $statusCode = $response->getStatusCode();
        $rawBody    = (string) $response->getBody();
        $data       = json_decode($rawBody, true) ?? [];

        if ($statusCode !== 200) {
            throw AuthenticationException::fromResponseBody($statusCode, $rawBody);
        }

        if (isset($data['ErrorCode']) || isset($data['fault'])) {
            throw AuthenticationException::fromResponseBody($statusCode, $rawBody);
        }

        $token     = $data['access_token'] ?? '';
        $expiresIn = (int) ($data['expires_in'] ?? 3600);
        $ttl       = max($expiresIn - self::CACHE_TTL_BUFFER, 1);

        if ($token === '') {
            throw new AuthenticationException('Empty access_token in response', $statusCode, null, $rawBody);
        }

        $this->cache->set($cacheKey, $token, $ttl);

        return $token;
    }

    public function clearCache(): void
    {
        $cacheKey = 'satusehat_token_' . md5($this->clientId);
        $this->cache->delete($cacheKey);
    }
}
