<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityRequestResponse;
use Wawaiguntang\Satusehat\Services\CoverageEligibilityRequestService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class CoverageEligibilityRequestServiceTest extends ServiceTestCase
{
    private function makeService(): CoverageEligibilityRequestService
    {
        return new CoverageEligibilityRequestService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('CoverageEligibilityRequest', 'cer-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\CoverageEligibilityRequest\CoverageEligibilityRequestDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'CoverageEligibilityRequest']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(CoverageEligibilityRequestResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('CoverageEligibilityRequest', 'cer-001');
        $response = $this->makeService()->getById('cer-001');
        $this->assertSame('cer-001', $response->id);
    }

    public function test_search_by_identifier(): void
    {
        $this->respondBundle('CoverageEligibilityRequest');
        $this->makeService()->searchByIdentifier('https://sys-ids.kemkes.go.id/insurance-number/org|12345');
        $this->assertStringContainsString('identifier=', $this->lastUri());
    }

    public function test_get_everything_returns_bundle(): void
    {
        $this->respondBundle('CoverageEligibilityRequest');
        $bundle = $this->makeService()->getEverything('cer-001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertStringContainsString('cer-001', $this->lastUri());
        $this->assertStringContainsString('everything', $this->lastUri());
    }
}
