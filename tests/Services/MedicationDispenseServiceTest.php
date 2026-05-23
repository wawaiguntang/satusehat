<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\MedicationDispenseResponse;
use Wawaiguntang\Satusehat\Services\MedicationDispenseService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class MedicationDispenseServiceTest extends ServiceTestCase
{
    private function makeService(): MedicationDispenseService
    {
        return new MedicationDispenseService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('MedicationDispense', 'md-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\MedicationDispense\MedicationDispenseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'MedicationDispense']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(MedicationDispenseResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('MedicationDispense', 'md-001');
        $response = $this->makeService()->getById('md-001');
        $this->assertSame('md-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('MedicationDispense');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('MedicationDispense', 'md-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\MedicationDispense\MedicationDispenseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'MedicationDispense', 'id' => 'md-001']);

        $this->makeService()->update('md-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/MedicationDispense/md-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('MedicationDispense', 'md-001');
        $this->makeService()->patch('md-001', [['op' => 'replace', 'path' => '/status', 'value' => 'completed']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
