<?php

namespace Wawaiguntang\Satusehat\Tests;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\SatusehatClient;
use Wawaiguntang\Satusehat\SatusehatClientFactory;
use Wawaiguntang\Satusehat\Tests\Support\ArrayCache;

class SatusehatClientFactoryTest extends TestCase
{
    public function test_create_returns_satusehat_client(): void
    {
        $factory = new Psr17Factory();
        $cache   = new ArrayCache();

        $client = SatusehatClientFactory::create(
            clientId:       'test-client-id',
            clientSecret:   'test-client-secret',
            cache:          $cache,
            httpClient:     new MockClient(),
            requestFactory: $factory,
            streamFactory:  $factory,
        );

        $this->assertInstanceOf(SatusehatClient::class, $client);
    }

    public function test_create_with_custom_urls(): void
    {
        $factory = new Psr17Factory();
        $cache   = new ArrayCache();

        $client = SatusehatClientFactory::create(
            clientId:       'test-client-id',
            clientSecret:   'test-client-secret',
            cache:          $cache,
            baseUrl:        'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1',
            authUrl:        'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1',
            httpClient:     new MockClient(),
            requestFactory: $factory,
            streamFactory:  $factory,
        );

        $this->assertInstanceOf(SatusehatClient::class, $client);
    }
}
