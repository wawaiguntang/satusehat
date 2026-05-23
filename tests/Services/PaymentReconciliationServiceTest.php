<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\PaymentReconciliationResponse;
use Wawaiguntang\Satusehat\Services\PaymentReconciliationService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class PaymentReconciliationServiceTest extends ServiceTestCase
{
    private function makeService(): PaymentReconciliationService
    {
        return new PaymentReconciliationService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('PaymentReconciliation', 'pr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\PaymentReconciliation\PaymentReconciliationDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'PaymentReconciliation']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(PaymentReconciliationResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('PaymentReconciliation', 'pr-001');
        $response = $this->makeService()->getById('pr-001');
        $this->assertSame('pr-001', $response->id);
    }

    public function test_search_by_claim_id(): void
    {
        $this->respondBundle('PaymentReconciliation');
        $this->makeService()->searchByClaimId('claim-001');
        $this->assertStringContainsString('detail-request=claim-001', $this->lastUri());
    }
}
