<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ServiceRequestResponse;
use Wawaiguntang\Satusehat\Services\ServiceRequestService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ServiceRequestServiceTest extends ServiceTestCase
{
    private function makeService(): ServiceRequestService
    {
        return new ServiceRequestService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('ServiceRequest', 'sr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ServiceRequest\ServiceRequestDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ServiceRequest']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ServiceRequestResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('ServiceRequest', 'sr-001');
        $response = $this->makeService()->getById('sr-001');
        $this->assertSame('sr-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('ServiceRequest');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('ServiceRequest');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_search_by_referral_number(): void
    {
        $this->respondBundle('ServiceRequest');
        $this->makeService()->searchByReferralNumber('http://sys-ids.kemkes.go.id/referral-number|12345');
        $this->assertStringContainsString('identifier=', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('ServiceRequest', 'sr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ServiceRequest\ServiceRequestDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ServiceRequest', 'id' => 'sr-001']);

        $this->makeService()->update('sr-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }
}
