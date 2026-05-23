<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\ImagingStudyResponse;
use Wawaiguntang\Satusehat\Services\ImagingStudyService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ImagingStudyServiceTest extends ServiceTestCase
{
    private function makeService(): ImagingStudyService
    {
        return new ImagingStudyService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('ImagingStudy', 'img-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ImagingStudy\ImagingStudyDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ImagingStudy']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ImagingStudyResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('ImagingStudy', 'img-001');
        $response = $this->makeService()->getById('img-001');
        $this->assertSame('img-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('ImagingStudy');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('ImagingStudy');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('ImagingStudy', 'img-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\ImagingStudy\ImagingStudyDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'ImagingStudy', 'id' => 'img-001']);

        $this->makeService()->update('img-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/ImagingStudy/img-001', $this->lastUri());
    }
}
