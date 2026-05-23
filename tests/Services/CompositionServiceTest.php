<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CompositionResponse;
use Wawaiguntang\Satusehat\Services\CompositionService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class CompositionServiceTest extends ServiceTestCase
{
    private function makeService(): CompositionService
    {
        return new CompositionService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Composition', 'comp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Composition\CompositionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Composition']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(CompositionResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Composition', 'comp-001');
        $response = $this->makeService()->getById('comp-001');
        $this->assertSame('comp-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Composition');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('Composition');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Composition', 'comp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Composition\CompositionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Composition', 'id' => 'comp-001']);

        $this->makeService()->update('comp-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Composition/comp-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('Composition', 'comp-001');
        $this->makeService()->patch('comp-001', [['op' => 'replace', 'path' => '/status', 'value' => 'final']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
