<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\MedicationResponse;
use Wawaiguntang\Satusehat\Services\MedicationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class MedicationServiceTest extends ServiceTestCase
{
    private function makeService(): MedicationService
    {
        return new MedicationService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Medication', 'med-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Medication\MedicationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Medication']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(MedicationResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Medication', 'med-001');
        $response = $this->makeService()->getById('med-001');
        $this->assertSame('med-001', $response->id);
    }

    public function test_search_by_code(): void
    {
        $this->respondBundle('Medication');
        $this->makeService()->searchByCode('93001019');
        $this->assertStringContainsString('code=93001019', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Medication', 'med-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Medication\MedicationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Medication', 'id' => 'med-001']);

        $this->makeService()->update('med-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }
}
