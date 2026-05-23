<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\LocationResponse;
use Wawaiguntang\Satusehat\Services\LocationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class LocationServiceTest extends ServiceTestCase
{
    private function makeService(): LocationService
    {
        return new LocationService($this->client);
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Location', 'loc-001');
        $response = $this->makeService()->getById('loc-001');

        $this->assertInstanceOf(LocationResponse::class, $response);
        $this->assertSame('loc-001', $response->id);
    }

    public function test_search_by_organization_returns_bundle(): void
    {
        $this->respondBundle('Location');
        $bundle = $this->makeService()->searchByOrganization('org-001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertStringContainsString('organization=org-001', $this->lastUri());
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Location', 'loc-new');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Location\LocationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Location']);

        $this->makeService()->create($dto);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Location', 'loc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Location\LocationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Location', 'id' => 'loc-001']);

        $this->makeService()->update('loc-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }

    public function test_patch_sends_patch_method(): void
    {
        $this->respondResource('Location', 'loc-001');
        $this->makeService()->patch('loc-001', [['op' => 'replace', 'path' => '/status', 'value' => 'inactive']]);

        $this->assertSame('PATCH', $this->lastMethod());
        $this->assertStringContainsString('/Location/loc-001', $this->lastUri());
    }
}
