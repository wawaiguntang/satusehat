<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ConditionResponse;
use Wawaiguntang\Satusehat\Services\ConditionService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ConditionServiceTest extends ServiceTestCase
{
    private function makeService(): ConditionService
    {
        return new ConditionService($this->client);
    }

    public function test_create_returns_condition_response(): void
    {
        $this->respondResource('Condition', 'cond-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Condition\ConditionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Condition']);

        $response = $this->makeService()->create($dto);

        $this->assertInstanceOf(ConditionResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Condition', 'cond-001');
        $response = $this->makeService()->getById('cond-001');

        $this->assertInstanceOf(ConditionResponse::class, $response);
        $this->assertStringContainsString('/Condition/cond-001', $this->lastUri());
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Condition', 2);
        $bundle = $this->makeService()->searchByPatient('P001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertSame(2, $bundle->total);
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('Condition');
        $this->makeService()->searchByEncounter('enc-001');

        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Condition', 'cond-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Condition\ConditionDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Condition', 'id' => 'cond-001']);

        $this->makeService()->update('cond-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }

    public function test_patch_sends_patch(): void
    {
        $this->respondResource('Condition', 'cond-001');
        $this->makeService()->patch('cond-001', [['op' => 'replace', 'path' => '/clinicalStatus', 'value' => 'resolved']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
