<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\SpecimenResponse;
use Wawaiguntang\Satusehat\Services\SpecimenService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class SpecimenServiceTest extends ServiceTestCase
{
    private function makeService(): SpecimenService
    {
        return new SpecimenService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Specimen', 'spec-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Specimen\SpecimenDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Specimen']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(SpecimenResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Specimen', 'spec-001');
        $response = $this->makeService()->getById('spec-001');
        $this->assertSame('spec-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Specimen');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_request(): void
    {
        $this->respondBundle('Specimen');
        $this->makeService()->searchByRequest('sr-001');
        $this->assertStringContainsString('request=sr-001', $this->lastUri());
    }

    public function test_search_by_collector(): void
    {
        $this->respondBundle('Specimen');
        $this->makeService()->searchByCollector('P001', '1001194237');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
        $this->assertStringContainsString('collector=1001194237', $this->lastUri());
    }

    public function test_search_by_subject_and_date(): void
    {
        $this->respondBundle('Specimen');
        $this->makeService()->searchBySubjectAndDate('P001', '2022-06-28');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
        $this->assertStringContainsString('collected=2022-06-28', $this->lastUri());
    }

    public function test_search_by_identifier_and_request(): void
    {
        $this->respondBundle('Specimen');
        $this->makeService()->searchByIdentifierAndRequest('http://sys-ids|1000000004', 'req-001');
        $this->assertStringContainsString('identifier=', $this->lastUri());
        $this->assertStringContainsString('request=req-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Specimen', 'spec-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Specimen\SpecimenDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Specimen', 'id' => 'spec-001']);

        $this->makeService()->update('spec-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }

    public function test_patch(): void
    {
        $this->respondResource('Specimen', 'spec-001');
        $this->makeService()->patch('spec-001', [['op' => 'replace', 'path' => '/status', 'value' => 'available']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
