<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\EpisodeOfCareResponse;
use Wawaiguntang\Satusehat\Services\EpisodeOfCareService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class EpisodeOfCareServiceTest extends ServiceTestCase
{
    private function makeService(): EpisodeOfCareService
    {
        return new EpisodeOfCareService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('EpisodeOfCare', 'eoc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\EpisodeOfCare\EpisodeOfCareDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'EpisodeOfCare']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(EpisodeOfCareResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('EpisodeOfCare', 'eoc-001');
        $response = $this->makeService()->getById('eoc-001');
        $this->assertSame('eoc-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('EpisodeOfCare');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('EpisodeOfCare', 'eoc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\EpisodeOfCare\EpisodeOfCareDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'EpisodeOfCare', 'id' => 'eoc-001']);

        $this->makeService()->update('eoc-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/EpisodeOfCare/eoc-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('EpisodeOfCare', 'eoc-001');
        $this->makeService()->patch('eoc-001', [['op' => 'replace', 'path' => '/status', 'value' => 'finished']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
