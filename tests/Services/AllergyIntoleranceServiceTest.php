<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\AllergyIntoleranceResponse;
use Wawaiguntang\Satusehat\Services\AllergyIntoleranceService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class AllergyIntoleranceServiceTest extends ServiceTestCase
{
    private function makeService(): AllergyIntoleranceService
    {
        return new AllergyIntoleranceService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('AllergyIntolerance', 'allergy-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\AllergyIntolerance\AllergyIntoleranceDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'AllergyIntolerance']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(AllergyIntoleranceResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('AllergyIntolerance', 'allergy-001');
        $response = $this->makeService()->getById('allergy-001');
        $this->assertSame('allergy-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('AllergyIntolerance');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('patient=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('AllergyIntolerance', 'allergy-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\AllergyIntolerance\AllergyIntoleranceDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'AllergyIntolerance', 'id' => 'allergy-001']);

        $this->makeService()->update('allergy-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/AllergyIntolerance/allergy-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('AllergyIntolerance', 'allergy-001');
        $this->makeService()->patch('allergy-001', [['op' => 'replace', 'path' => '/clinicalStatus', 'value' => 'resolved']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
