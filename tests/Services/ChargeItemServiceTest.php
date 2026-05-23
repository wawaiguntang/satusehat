<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ChargeItemResponse;
use Wawaiguntang\Satusehat\Services\ChargeItemService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ChargeItemServiceTest extends ServiceTestCase
{
    private function makeService(): ChargeItemService
    {
        return new ChargeItemService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('ChargeItem', 'ci-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ChargeItem\ChargeItemDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ChargeItem']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ChargeItemResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('ChargeItem', 'ci-001');
        $response = $this->makeService()->getById('ci-001');
        $this->assertSame('ci-001', $response->id);
    }

    public function test_search_by_account_and_patient(): void
    {
        $this->respondBundle('ChargeItem');
        $this->makeService()->searchByAccount('acc-001', 'P001');
        $this->assertStringContainsString('account=acc-001', $this->lastUri());
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_account_only(): void
    {
        $this->respondBundle('ChargeItem');
        $this->makeService()->searchByAccount('acc-001');
        $this->assertStringContainsString('account=acc-001', $this->lastUri());
        $this->assertStringNotContainsString('subject=', $this->lastUri());
    }
}
