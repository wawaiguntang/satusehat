<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\RelatedPersonResponse;
use Wawaiguntang\Satusehat\Services\RelatedPersonService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class RelatedPersonServiceTest extends ServiceTestCase
{
    private function makeService(): RelatedPersonService
    {
        return new RelatedPersonService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('RelatedPerson', 'rp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\RelatedPerson\RelatedPersonDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'RelatedPerson']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(RelatedPersonResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('RelatedPerson', 'rp-001');
        $response = $this->makeService()->getById('rp-001');
        $this->assertSame('rp-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('RelatedPerson');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }

    public function test_search_by_nik(): void
    {
        $this->respondBundle('RelatedPerson');
        $this->makeService()->searchByNik('3674000011112222');
        $this->assertStringContainsString('identifier=', $this->lastUri());
        $this->assertStringContainsString('3674000011112222', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('RelatedPerson', 'rp-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\RelatedPerson\RelatedPersonDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'RelatedPerson', 'id' => 'rp-001']);

        $this->makeService()->update('rp-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/RelatedPerson/rp-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('RelatedPerson', 'rp-001');
        $this->makeService()->patch('rp-001', [['op' => 'replace', 'path' => '/active', 'value' => false]]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
