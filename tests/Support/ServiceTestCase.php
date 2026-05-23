<?php

namespace Wawaiguntang\Satusehat\Tests\Support;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Auth\SatusehatAuthenticator;
use Wawaiguntang\Satusehat\Http\SatusehatHttpClient;

abstract class ServiceTestCase extends TestCase
{
    protected MockClient          $mockHttp;
    protected SatusehatHttpClient $client;

    protected function setUp(): void
    {
        $this->mockHttp = new MockClient();
        $factory        = new Psr17Factory();

        /** @var SatusehatAuthenticator&MockObject $mockAuth */
        $mockAuth = $this->createMock(SatusehatAuthenticator::class);
        $mockAuth->method('getToken')->willReturn('test-token');

        $this->client = new SatusehatHttpClient(
            baseUrl:        'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
            httpClient:     $this->mockHttp,
            requestFactory: $factory,
            streamFactory:  $factory,
            authenticator:  $mockAuth,
        );
    }

    protected function respond(array $body, int $status = 200): void
    {
        $this->mockHttp->addResponse(new Response($status, [], json_encode($body)));
    }

    protected function respondResource(string $resourceType, string $id = 'res-001', array $extra = []): void
    {
        $this->respond(array_merge([
            'resourceType' => $resourceType,
            'id'           => $id,
            'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-01T00:00:00Z'],
        ], $extra));
    }

    protected function respondBundle(string $resourceType, int $total = 1, array $extra = []): void
    {
        $entries = [];
        for ($i = 1; $i <= $total; $i++) {
            $entries[] = ['resource' => array_merge([
                'resourceType' => $resourceType,
                'id'           => "res-00{$i}",
                'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-01T00:00:00Z'],
            ], $extra)];
        }

        $this->respond([
            'resourceType' => 'Bundle',
            'total'        => $total,
            'entry'        => $entries,
        ]);
    }

    protected function lastRequest(): \Psr\Http\Message\RequestInterface
    {
        $requests = $this->mockHttp->getRequests();
        return end($requests);
    }

    protected function lastUri(): string
    {
        return (string) $this->lastRequest()->getUri();
    }

    protected function lastMethod(): string
    {
        return $this->lastRequest()->getMethod();
    }
}
