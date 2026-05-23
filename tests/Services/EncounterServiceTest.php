<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EncounterResponse;
use Wawaiguntang\Satusehat\Services\EncounterService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class EncounterServiceTest extends ServiceTestCase
{
    private function makeService(): EncounterService
    {
        return new EncounterService($this->client);
    }

    private function encounterData(string $id = 'enc-001', string $status = 'arrived'): array
    {
        return [
            'resourceType' => 'Encounter',
            'id'           => $id,
            'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-01T00:00:00Z'],
            'status'       => $status,
            'class'        => ['system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode', 'code' => 'AMB'],
            'subject'      => ['reference' => 'Patient/P001'],
        ];
    }

    public function test_create_returns_encounter_response(): void
    {
        $this->respond($this->encounterData());
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Encounter\EncounterDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Encounter', 'status' => 'arrived']);

        $response = $this->makeService()->create($dto);

        $this->assertInstanceOf(EncounterResponse::class, $response);
        $this->assertSame('enc-001', $response->id);
        $this->assertSame('arrived', $response->status);
    }

    public function test_get_by_id_returns_encounter_response(): void
    {
        $this->respond($this->encounterData('enc-999', 'finished'));
        $response = $this->makeService()->getById('enc-999');

        $this->assertInstanceOf(EncounterResponse::class, $response);
        $this->assertSame('enc-999', $response->id);
        $this->assertSame('finished', $response->status);
    }

    public function test_search_by_patient_returns_bundle_response(): void
    {
        $this->respond([
            'resourceType' => 'Bundle',
            'total'        => 2,
            'entry'        => [
                ['resource' => $this->encounterData('enc-001')],
                ['resource' => $this->encounterData('enc-002')],
            ],
        ]);

        $bundle = $this->makeService()->searchByPatient('P001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertSame(2, $bundle->total);
        $this->assertCount(2, $bundle->getEntries());
        $this->assertInstanceOf(EncounterResponse::class, $bundle->first());
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_update_sends_put(): void
    {
        $this->respond($this->encounterData());
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Encounter\EncounterDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Encounter', 'id' => 'enc-001']);

        $this->makeService()->update('enc-001', $dto);
        $this->assertSame('PUT', $this->lastMethod());
    }

    public function test_patch_sends_correct_request(): void
    {
        $this->respond($this->encounterData('enc-001', 'finished'));

        $response = $this->makeService()->patch('enc-001', [
            ['op' => 'replace', 'path' => '/status', 'value' => 'finished'],
        ]);

        $this->assertSame('PATCH', $this->lastMethod());
        $this->assertSame('application/json-patch+json', $this->lastRequest()->getHeaderLine('Content-Type'));
        $this->assertSame('finished', $response->status);
    }

    public function test_get_everything_returns_bundle(): void
    {
        $this->respond([
            'resourceType' => 'Bundle',
            'total'        => 1,
            'entry'        => [['resource' => $this->encounterData()]],
        ]);

        $bundle = $this->makeService()->getEverything('enc-001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertSame(1, $bundle->total);
        $this->assertStringContainsString('enc-001', $this->lastUri());
    }
}
