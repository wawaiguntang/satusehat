<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\MedicationRequestResponse;
use Wawaiguntang\Satusehat\Services\MedicationRequestService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class MedicationRequestServiceTest extends ServiceTestCase
{
    private function makeService(): MedicationRequestService
    {
        return new MedicationRequestService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('MedicationRequest', 'mr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\MedicationRequest\MedicationRequestDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'MedicationRequest']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(MedicationRequestResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('MedicationRequest', 'mr-001');
        $response = $this->makeService()->getById('mr-001');
        $this->assertSame('mr-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('MedicationRequest');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('MedicationRequest');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('MedicationRequest', 'mr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\MedicationRequest\MedicationRequestDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'MedicationRequest', 'id' => 'mr-001']);

        $this->makeService()->update('mr-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/MedicationRequest/mr-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('MedicationRequest', 'mr-001');
        $this->makeService()->patch('mr-001', [['op' => 'replace', 'path' => '/status', 'value' => 'cancelled']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
