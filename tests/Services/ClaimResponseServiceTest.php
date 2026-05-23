<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponseResponse;
use Wawaiguntang\Satusehat\Services\ClaimResponseService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ClaimResponseServiceTest extends ServiceTestCase
{
    private function makeService(): ClaimResponseService
    {
        return new ClaimResponseService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('ClaimResponse', 'cr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ClaimResponse\ClaimResponseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ClaimResponse']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ClaimResponseResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('ClaimResponse', 'cr-001');
        $response = $this->makeService()->getById('cr-001');
        $this->assertSame('cr-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('ClaimResponse');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }
}
