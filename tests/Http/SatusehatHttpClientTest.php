<?php

namespace Wawaiguntang\Satusehat\Tests\Http;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Auth\SatusehatAuthenticator;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ForbiddenException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\ServerException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;
use Wawaiguntang\Satusehat\Http\SatusehatHttpClient;

class SatusehatHttpClientTest extends TestCase
{
    private MockClient   $mockClient;
    private Psr17Factory $factory;
    /** @var SatusehatAuthenticator&MockObject */
    private SatusehatAuthenticator $mockAuth;

    protected function setUp(): void
    {
        $this->mockClient = new MockClient();
        $this->factory    = new Psr17Factory();
        $this->mockAuth   = $this->createMock(SatusehatAuthenticator::class);
        $this->mockAuth->method('getToken')->willReturn('test-bearer-token');
    }

    private function makeHttpClient(int $maxRetries = 1, int $retryDelayMs = 0): SatusehatHttpClient
    {
        return new SatusehatHttpClient(
            baseUrl:        'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
            httpClient:     $this->mockClient,
            requestFactory: $this->factory,
            streamFactory:  $this->factory,
            authenticator:  $this->mockAuth,
            maxRetries:     $maxRetries,
            retryDelayMs:   $retryDelayMs,
        );
    }

    public function test_get_returns_decoded_array(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'resourceType' => 'Encounter',
            'id'           => 'enc-001',
        ])));

        $result = $this->makeHttpClient()->get('/Encounter/enc-001');

        $this->assertSame('enc-001', $result['id']);
        $this->assertSame('Encounter', $result['resourceType']);
    }

    public function test_post_sends_json_body(): void
    {
        $this->mockClient->addResponse(new Response(201, [], json_encode([
            'resourceType' => 'Encounter',
            'id'           => 'new-enc',
        ])));

        $client = $this->makeHttpClient();
        $result = $client->post('/Encounter', ['resourceType' => 'Encounter', 'status' => 'arrived']);

        $request = $this->mockClient->getRequests()[0];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertSame('new-enc', $result['id']);
    }

    public function test_throws_validation_exception_on_400(): void
    {
        $this->mockClient->addResponse(new Response(400, [], json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [['severity' => 'error', 'code' => 'invalid', 'details' => ['text' => 'Bad request']]],
        ])));

        $this->expectException(ValidationException::class);
        $this->makeHttpClient()->get('/Encounter/bad');
    }

    public function test_throws_authentication_exception_on_401(): void
    {
        $this->mockClient->addResponse(new Response(401, [], json_encode([
            'fault' => ['faultstring' => 'Invalid credentials', 'detail' => ['errorcode' => 'oauth.v2.InvalidAccessToken']],
        ])));

        $this->expectException(AuthenticationException::class);
        $this->makeHttpClient()->get('/Encounter/x');
    }

    public function test_throws_forbidden_exception_on_403(): void
    {
        $this->mockClient->addResponse(new Response(403, [], json_encode([
            'fault' => ['faultstring' => 'Forbidden', 'detail' => ['errorcode' => 'oauth.v2.Forbidden']],
        ])));

        $this->expectException(ForbiddenException::class);
        $this->makeHttpClient()->get('/Encounter/x');
    }

    public function test_throws_not_found_exception_on_404(): void
    {
        $this->mockClient->addResponse(new Response(404, [], json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [['severity' => 'error', 'code' => 'not-found', 'details' => ['text' => 'Not found']]],
        ])));

        $this->expectException(ResourceNotFoundException::class);
        $this->makeHttpClient()->get('/Encounter/nonexistent');
    }

    public function test_throws_server_exception_on_500(): void
    {
        $this->mockClient->addResponse(new Response(500, [], json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [['severity' => 'fatal', 'code' => 'exception', 'details' => ['text' => 'Internal error']]],
        ])));

        $this->expectException(ServerException::class);
        $this->makeHttpClient()->get('/Encounter/x');
    }

    public function test_bearer_token_injected_in_header(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode(['resourceType' => 'Bundle', 'total' => 0])));

        $this->makeHttpClient()->get('/Encounter');

        $request = $this->mockClient->getRequests()[0];
        $this->assertSame('Bearer test-bearer-token', $request->getHeaderLine('Authorization'));
    }

    public function test_patch_sends_json_patch_content_type(): void
    {
        $this->mockClient->addResponse(new Response(200, [], json_encode([
            'resourceType' => 'Encounter',
            'id'           => 'enc-001',
        ])));

        $this->makeHttpClient()->patch('/Encounter/enc-001', [
            ['op' => 'replace', 'path' => '/status', 'value' => 'finished'],
        ]);

        $request = $this->mockClient->getRequests()[0];
        $this->assertSame('application/json-patch+json', $request->getHeaderLine('Content-Type'));
    }

    public function test_throws_server_exception_on_503_plain_text(): void
    {
        $this->mockClient->addResponse(new Response(503, ['Content-Type' => 'text/plain'], 'no healthy upstream'));

        $this->expectException(ServerException::class);
        $this->makeHttpClient()->get('/Encounter');
    }

    public function test_200_consent_suppressed_does_not_throw(): void
    {
        $consentBody = json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [[
                'severity' => 'information',
                'code'     => 'suppressed',
                'details'  => ['text' => 'The operation did not return any information due to consent or privacy rules.'],
            ]],
        ]);
        $this->mockClient->addResponse(new Response(200, [], $consentBody));

        $result = $this->makeHttpClient()->get('/Encounter/consent-restricted');

        $this->assertSame('OperationOutcome', $result['resourceType']);
        $this->assertSame('information', $result['issue'][0]['severity']);
    }

    public function test_422_throws_validation_exception(): void
    {
        $this->mockClient->addResponse(new Response(422, [], json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [['severity' => 'error', 'code' => 'invalid', 'details' => ['text' => 'Unprocessable entity']]],
        ])));

        $this->expectException(\Wawaiguntang\Satusehat\Exceptions\SatusehatException::class);
        $this->makeHttpClient()->post('/Encounter', []);
    }

    public function test_apigee_no_product_match_401_throws_authentication_exception(): void
    {
        $this->mockClient->addResponse(new Response(401, [], json_encode([
            'fault' => [
                'faultstring' => 'Invalid API call as no apiproduct match found',
                'detail'      => ['errorcode' => 'keymanagement.service.InvalidAPICallAsNoApiProductMatchFound'],
            ],
        ])));

        $this->expectException(AuthenticationException::class);
        $this->makeHttpClient()->get('/Patient');
    }

    public function test_retries_on_503_and_succeeds(): void
    {
        $this->mockClient->addResponse(new Response(503, [], 'no healthy upstream'));
        $this->mockClient->addResponse(new Response(200, [], json_encode(['resourceType' => 'Patient', 'id' => 'P001'])));

        $result = $this->makeHttpClient(maxRetries: 2)->get('/Patient/P001');

        $this->assertSame('P001', $result['id']);
        $this->assertCount(2, $this->mockClient->getRequests());
    }

    public function test_throws_after_max_retries_exhausted(): void
    {
        $this->mockClient->addResponse(new Response(503, [], 'no healthy upstream'));
        $this->mockClient->addResponse(new Response(503, [], 'no healthy upstream'));
        $this->mockClient->addResponse(new Response(503, [], 'no healthy upstream'));

        $this->expectException(ServerException::class);
        $this->makeHttpClient(maxRetries: 3)->get('/Patient/P001');
    }

    public function test_does_not_retry_on_4xx(): void
    {
        $this->mockClient->addResponse(new Response(404, [], json_encode([
            'resourceType' => 'OperationOutcome',
            'issue'        => [['severity' => 'error', 'code' => 'not-found']],
        ])));

        $this->expectException(ResourceNotFoundException::class);
        $this->makeHttpClient(maxRetries: 3)->get('/Patient/nonexistent');

        $this->assertCount(1, $this->mockClient->getRequests());
    }
}
