<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\QuestionnaireResponseResponse;
use Wawaiguntang\Satusehat\Services\QuestionnaireResponseService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class QuestionnaireResponseServiceTest extends ServiceTestCase
{
    private function makeService(): QuestionnaireResponseService
    {
        return new QuestionnaireResponseService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('QuestionnaireResponse', 'qr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\QuestionnaireResponse\QuestionnaireResponseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'QuestionnaireResponse']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(QuestionnaireResponseResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('QuestionnaireResponse', 'qr-001');
        $response = $this->makeService()->getById('qr-001');
        $this->assertSame('qr-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('QuestionnaireResponse');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('QuestionnaireResponse', 'qr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\QuestionnaireResponse\QuestionnaireResponseDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'QuestionnaireResponse', 'id' => 'qr-001']);

        $this->makeService()->update('qr-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/QuestionnaireResponse/qr-001', $this->lastUri());
    }
}
