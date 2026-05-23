<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\PaymentNoticeResponse;
use Wawaiguntang\Satusehat\Services\PaymentNoticeService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class PaymentNoticeServiceTest extends ServiceTestCase
{
    private function makeService(): PaymentNoticeService
    {
        return new PaymentNoticeService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('PaymentNotice', 'pn-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\PaymentNotice\PaymentNoticeDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'PaymentNotice']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(PaymentNoticeResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('PaymentNotice', 'pn-001');
        $response = $this->makeService()->getById('pn-001');
        $this->assertSame('pn-001', $response->id);
    }

    public function test_search_by_claim_id(): void
    {
        $this->respondBundle('PaymentNotice');
        $this->makeService()->searchByClaimId('claim-001');
        $this->assertStringContainsString('request=claim-001', $this->lastUri());
    }
}
