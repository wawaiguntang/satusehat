<?php

namespace Wawaiguntang\Satusehat\Tests\Auth;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Auth\SatusehatAuthenticator;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Tests\Support\ArrayCache;

class SatusehatAuthenticatorTest extends TestCase
{
    private MockClient      $mockClient;
    private Psr17Factory    $factory;
    private ArrayCache      $cache;

    protected function setUp(): void
    {
        $this->mockClient = new MockClient();
        $this->factory    = new Psr17Factory();
        $this->cache      = new ArrayCache();
    }

    private function makeAuthenticator(): SatusehatAuthenticator
    {
        return new SatusehatAuthenticator(
            clientId:       'test-client-id',
            clientSecret:   'test-client-secret',
            authUrl:        'https://api-satusehat.kemkes.go.id/oauth2/v1',
            httpClient:     $this->mockClient,
            requestFactory: $this->factory,
            streamFactory:  $this->factory,
            cache:          $this->cache,
        );
    }

    public function test_fetches_token_successfully(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'access_token' => 'my-token-123',
            'expires_in'   => 3600,
            'token_type'   => 'Bearer',
        ])));

        $auth  = $this->makeAuthenticator();
        $token = $auth->getToken();

        $this->assertSame('my-token-123', $token);
    }

    public function test_caches_token_on_second_call(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'access_token' => 'cached-token',
            'expires_in'   => 3600,
        ])));

        $auth = $this->makeAuthenticator();
        $auth->getToken();
        $token = $auth->getToken();

        $this->assertSame('cached-token', $token);
        $this->assertCount(1, $this->mockClient->getRequests());
    }

    public function test_throws_authentication_exception_on_401(): void
    {
        $this->mockClient->addResponse(new Response(401, [], json_encode([
            'ErrorCode' => 'invalid_client',
            'Error'     => 'ClientId is Invalid',
        ])));

        $this->expectException(AuthenticationException::class);

        $this->makeAuthenticator()->getToken();
    }

    public function test_throws_on_empty_access_token(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'access_token' => '',
            'expires_in'   => 3600,
        ])));

        $this->expectException(AuthenticationException::class);

        $this->makeAuthenticator()->getToken();
    }

    public function test_clear_cache_forces_refetch(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'access_token' => 'token-1',
            'expires_in'   => 3600,
        ])));
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'access_token' => 'token-2',
            'expires_in'   => 3600,
        ])));

        $auth = $this->makeAuthenticator();
        $auth->getToken();
        $auth->clearCache();
        $token = $auth->getToken();

        $this->assertSame('token-2', $token);
        $this->assertCount(2, $this->mockClient->getRequests());
    }
}
