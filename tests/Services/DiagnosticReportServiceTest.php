<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\DiagnosticReportResponse;
use Wawaiguntang\Satusehat\Services\DiagnosticReportService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class DiagnosticReportServiceTest extends ServiceTestCase
{
    private function makeService(): DiagnosticReportService
    {
        return new DiagnosticReportService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('DiagnosticReport', 'dr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\DiagnosticReport\DiagnosticReportDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'DiagnosticReport']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(DiagnosticReportResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('DiagnosticReport', 'dr-001');
        $response = $this->makeService()->getById('dr-001');
        $this->assertSame('dr-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('DiagnosticReport');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('DiagnosticReport');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('DiagnosticReport', 'dr-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\DiagnosticReport\DiagnosticReportDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'DiagnosticReport', 'id' => 'dr-001']);

        $this->makeService()->update('dr-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/DiagnosticReport/dr-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('DiagnosticReport', 'dr-001');
        $this->makeService()->patch('dr-001', [['op' => 'replace', 'path' => '/status', 'value' => 'final']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
