<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\CarePlanResponse;
use Wawaiguntang\Satusehat\Services\CarePlanService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class CarePlanServiceTest extends ServiceTestCase
{
    private function makeService(): CarePlanService
    {
        return new CarePlanService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('CarePlan', 'cp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\CarePlan\CarePlanDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'CarePlan']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(CarePlanResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('CarePlan', 'cp-001');
        $response = $this->makeService()->getById('cp-001');
        $this->assertSame('cp-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('CarePlan');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('CarePlan', 'cp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\CarePlan\CarePlanDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'CarePlan', 'id' => 'cp-001']);

        $this->makeService()->update('cp-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }
}
