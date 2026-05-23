<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ObservationResponse;
use Wawaiguntang\Satusehat\Services\ObservationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ObservationServiceTest extends ServiceTestCase
{
    private function makeService(): ObservationService
    {
        return new ObservationService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Observation', 'obs-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Observation\ObservationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Observation']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ObservationResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Observation', 'obs-001');
        $response = $this->makeService()->getById('obs-001');

        $this->assertSame('obs-001', $response->id);
        $this->assertStringContainsString('/Observation/obs-001', $this->lastUri());
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Observation');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('Observation');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_search_by_code(): void
    {
        $this->respondBundle('Observation');
        $this->makeService()->searchByCode('55284-4');
        $this->assertStringContainsString('code=55284-4', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Observation', 'obs-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Observation\ObservationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Observation', 'id' => 'obs-001']);

        $this->makeService()->update('obs-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Observation/obs-001', $this->lastUri());
    }

    public function test_patch_sends_patch(): void
    {
        $this->respondResource('Observation', 'obs-001');
        $this->makeService()->patch('obs-001', [['op' => 'replace', 'path' => '/status', 'value' => 'final']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
