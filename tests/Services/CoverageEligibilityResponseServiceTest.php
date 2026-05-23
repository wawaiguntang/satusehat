<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityResponseResponse;
use Wawaiguntang\Satusehat\Services\CoverageEligibilityResponseService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class CoverageEligibilityResponseServiceTest extends ServiceTestCase
{
    private function makeService(): CoverageEligibilityResponseService
    {
        return new CoverageEligibilityResponseService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('CoverageEligibilityResponse', 'ceres-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\CoverageEligibilityResponse\CoverageEligibilityResponseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'CoverageEligibilityResponse']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(CoverageEligibilityResponseResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('CoverageEligibilityResponse', 'ceres-001');
        $response = $this->makeService()->getById('ceres-001');
        $this->assertSame('ceres-001', $response->id);
    }

    public function test_search_by_request(): void
    {
        $this->respondBundle('CoverageEligibilityResponse');
        $this->makeService()->searchByRequest('cer-001');
        $this->assertStringContainsString('request=cer-001', $this->lastUri());
    }
}
