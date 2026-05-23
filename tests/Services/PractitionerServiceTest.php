<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PractitionerResponse;
use Wawaiguntang\Satusehat\Services\PractitionerService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class PractitionerServiceTest extends ServiceTestCase
{
    private function makeService(): PractitionerService
    {
        return new PractitionerService($this->client);
    }

    public function test_get_by_id_returns_typed_response(): void
    {
        $this->respondResource('Practitioner', 'N10000001');
        $response = $this->makeService()->getById('N10000001');

        $this->assertInstanceOf(PractitionerResponse::class, $response);
        $this->assertSame('N10000001', $response->id);
        $this->assertSame('GET', $this->lastMethod());
        $this->assertStringContainsString('/Practitioner/N10000001', $this->lastUri());
    }

    public function test_get_by_nik_returns_bundle(): void
    {
        $this->respondBundle('Practitioner');
        $bundle = $this->makeService()->getByNik('3271234567890001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertStringContainsString('identifier=', $this->lastUri());
        $this->assertStringContainsString('3271234567890001', $this->lastUri());
    }
}
