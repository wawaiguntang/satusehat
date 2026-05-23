<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\CoverageResponse;
use Wawaiguntang\Satusehat\Services\CoverageService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class CoverageServiceTest extends ServiceTestCase
{
    private function makeService(): CoverageService
    {
        return new CoverageService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Coverage', 'cov-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Coverage\CoverageDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Coverage']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(CoverageResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Coverage', 'cov-001');
        $response = $this->makeService()->getById('cov-001');
        $this->assertSame('cov-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Coverage');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('beneficiary=P001', $this->lastUri());
    }

    public function test_search_by_patient_and_identifier(): void
    {
        $this->respondBundle('Coverage');
        $this->makeService()->searchByPatientAndIdentifier('P001', 'https://sys-ids.kemkes.go.id/insurance-subscriber/org|123');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
        $this->assertStringContainsString('identifier=', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Coverage', 'cov-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Coverage\CoverageDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Coverage', 'id' => 'cov-001']);

        $this->makeService()->update('cov-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Coverage/cov-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('Coverage', 'cov-001');
        $this->makeService()->patch('cov-001', [['op' => 'replace', 'path' => '/status', 'value' => 'cancelled']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
