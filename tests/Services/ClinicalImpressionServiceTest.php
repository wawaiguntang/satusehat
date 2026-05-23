<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ClinicalImpressionResponse;
use Wawaiguntang\Satusehat\Services\ClinicalImpressionService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ClinicalImpressionServiceTest extends ServiceTestCase
{
    private function makeService(): ClinicalImpressionService
    {
        return new ClinicalImpressionService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('ClinicalImpression', 'ci-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ClinicalImpression\ClinicalImpressionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ClinicalImpression']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ClinicalImpressionResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('ClinicalImpression', 'ci-001');
        $response = $this->makeService()->getById('ci-001');
        $this->assertSame('ci-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('ClinicalImpression');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('ClinicalImpression');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('ClinicalImpression', 'ci-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ClinicalImpression\ClinicalImpressionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ClinicalImpression', 'id' => 'ci-001']);

        $this->makeService()->update('ci-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/ClinicalImpression/ci-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('ClinicalImpression', 'ci-001');
        $this->makeService()->patch('ci-001', [['op' => 'replace', 'path' => '/status', 'value' => 'completed']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
