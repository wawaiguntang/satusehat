<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ProcedureResponse;
use Wawaiguntang\Satusehat\Services\ProcedureService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class ProcedureServiceTest extends ServiceTestCase
{
    private function makeService(): ProcedureService
    {
        return new ProcedureService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Procedure', 'proc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Procedure\ProcedureDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Procedure']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(ProcedureResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Procedure', 'proc-001');
        $response = $this->makeService()->getById('proc-001');
        $this->assertSame('proc-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Procedure');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_search_by_encounter(): void
    {
        $this->respondBundle('Procedure');
        $this->makeService()->searchByEncounter('enc-001');
        $this->assertStringContainsString('encounter=enc-001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respondResource('Procedure', 'proc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Procedure\ProcedureDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Procedure', 'id' => 'proc-001']);

        $this->makeService()->update('proc-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
        $this->assertStringContainsString('/Procedure/proc-001', $this->lastUri());
    }

    public function test_patch(): void
    {
        $this->respondResource('Procedure', 'proc-001');
        $this->makeService()->patch('proc-001', [['op' => 'replace', 'path' => '/status', 'value' => 'completed']]);
        $this->assertSame('PATCH', $this->lastMethod());
    }
}
