<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponse;
use Wawaiguntang\Satusehat\Services\ClaimService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ClaimServiceTest extends ServiceTestCase
{
    private function makeService(): ClaimService
    {
        return new ClaimService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Claim', 'claim-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Claim\ClaimDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Claim']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ClaimResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Claim', 'claim-001');
        $response = $this->makeService()->getById('claim-001');
        $this->assertSame('claim-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Claim');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }

    public function test_search_by_identifier_no_sep(): void
    {
        $this->respondBundle('Claim');
        $this->makeService()->searchByIdentifier('http://sys-ids.kemkes.go.id/claim-number/org|SEP001');
        $this->assertStringContainsString('identifier=', $this->lastUri());
    }
}
