<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\InvoiceResponse;
use Wawaiguntang\Satusehat\Services\InvoiceService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class InvoiceServiceTest extends ServiceTestCase
{
    private function makeService(): InvoiceService
    {
        return new InvoiceService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Invoice', 'inv-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Invoice\InvoiceDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Invoice']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(InvoiceResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Invoice', 'inv-001');
        $response = $this->makeService()->getById('inv-001');
        $this->assertSame('inv-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Invoice');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }
}
