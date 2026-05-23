<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ImmunizationResponse;
use Wawaiguntang\Satusehat\Services\ImmunizationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ImmunizationServiceTest extends ServiceTestCase
{
    private function makeService(): ImmunizationService
    {
        return new ImmunizationService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Immunization', 'imm-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Immunization\ImmunizationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Immunization']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ImmunizationResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Immunization', 'imm-001');
        $response = $this->makeService()->getById('imm-001');
        $this->assertSame('imm-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Immunization');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Immunization', 'imm-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Immunization\ImmunizationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Immunization', 'id' => 'imm-001']);

        $this->makeService()->update('imm-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Immunization/imm-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('Immunization', 'imm-001');
        $this->makeService()->patch('imm-001', [['op' => 'replace', 'path' => '/status', 'value' => 'completed']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
