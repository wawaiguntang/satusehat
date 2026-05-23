<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\OrganizationResponse;
use Wawaiguntang\Satusehat\Services\OrganizationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class OrganizationServiceTest extends ServiceTestCase
{
    private function makeService(): OrganizationService
    {
        return new OrganizationService($this->client);
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Organization', 'org-001');
        $response = $this->makeService()->getById('org-001');

        $this->assertInstanceOf(OrganizationResponse::class, $response);
        $this->assertSame('org-001', $response->id);
        $this->assertStringContainsString('/Organization/org-001', $this->lastUri());
    }

    public function test_search_returns_bundle(): void
    {
        $this->respondBundle('Organization', 2);
        $bundle = $this->makeService()->search('RSCM');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertSame(2, $bundle->total);
        $this->assertStringContainsString('name=RSCM', $this->lastUri());
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Organization', 'org-new');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Organization\OrganizationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Organization']);

        $response = $this->makeService()->create($dto);

        $this->assertInstanceOf(OrganizationResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Organization', 'org-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Organization\OrganizationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Organization', 'id' => 'org-001']);

        $this->makeService()->update('org-001', $dto);

        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Organization/org-001', $this->lastUri());
    }
}
