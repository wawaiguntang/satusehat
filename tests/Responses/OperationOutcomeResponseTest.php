<?php

namespace Wawaiguntang\Satusehat\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Responses\OperationOutcomeResponse;

class OperationOutcomeResponseTest extends TestCase
{
    public function test_from_fhir_operation_outcome(): void
    {
        $data = [
            'resourceType' => 'OperationOutcome',
            'issue'        => [[
                'severity'    => 'error',
                'code'        => 'invalid',
                'details'     => ['text' => 'Field X is required'],
                'diagnostics' => 'Field X cannot be empty',
                'expression'  => ['Encounter.status'],
            ]],
        ];

        $outcome = OperationOutcomeResponse::fromArray($data);

        $this->assertSame('error', $outcome->severity);
        $this->assertSame('invalid', $outcome->code);
        $this->assertSame('Field X is required', $outcome->details);
        $this->assertSame('Field X cannot be empty', $outcome->diagnostics);
        $this->assertSame('Encounter.status', $outcome->expression);
    }

    public function test_from_apigee_fault(): void
    {
        $data = [
            'fault' => [
                'faultstring' => 'Invalid Access Token',
                'detail'      => ['errorcode' => 'oauth.v2.InvalidAccessToken'],
            ],
        ];

        $outcome = OperationOutcomeResponse::fromApigee($data);

        $this->assertSame('error', $outcome->severity);
        $this->assertSame('security', $outcome->code);
        $this->assertSame('Invalid Access Token', $outcome->details);
        $this->assertSame('oauth.v2.InvalidAccessToken', $outcome->diagnostics);
    }

    public function test_from_auth_error(): void
    {
        $data = [
            'ErrorCode' => 'invalid_client',
            'Error'     => 'ClientId is Invalid',
        ];

        $outcome = OperationOutcomeResponse::fromAuthError($data);

        $this->assertSame('error', $outcome->severity);
        $this->assertSame('ClientId is Invalid', $outcome->details);
        $this->assertSame('invalid_client', $outcome->diagnostics);
    }
}
