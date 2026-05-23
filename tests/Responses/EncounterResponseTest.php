<?php

namespace Wawaiguntang\Satusehat\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Responses\Resources\EncounterResponse;

class EncounterResponseTest extends TestCase
{
    private function makeFhirEncounter(): array
    {
        return [
            'resourceType' => 'Encounter',
            'id'           => 'enc-abc-123',
            'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-15T10:00:00+07:00'],
            'status'       => 'finished',
            'class'        => ['system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode', 'code' => 'AMB', 'display' => 'ambulatory'],
            'subject'      => ['reference' => 'Patient/P001', 'display' => 'John Doe'],
            'period'       => ['start' => '2024-01-15T08:00:00+07:00', 'end' => '2024-01-15T10:00:00+07:00'],
            'serviceProvider' => ['reference' => 'Organization/org-001'],
            'identifier'   => [['system' => 'http://example.com', 'value' => 'ENC-001']],
        ];
    }

    public function test_maps_base_fields(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertSame('enc-abc-123', $response->id);
        $this->assertSame('Encounter', $response->resourceType);
        $this->assertSame('1', $response->versionId);
        $this->assertSame('2024-01-15T10:00:00+07:00', $response->lastUpdated);
    }

    public function test_maps_status(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertSame('finished', $response->status);
    }

    public function test_maps_class_coding(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertSame('AMB', $response->class->code);
        $this->assertSame('ambulatory', $response->class->display);
    }

    public function test_maps_subject_reference(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertSame('Patient/P001', $response->subject->reference);
        $this->assertSame('John Doe', $response->subject->display);
    }

    public function test_maps_period(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertSame('2024-01-15T08:00:00+07:00', $response->period->start);
        $this->assertSame('2024-01-15T10:00:00+07:00', $response->period->end);
    }

    public function test_maps_identifiers(): void
    {
        $response = EncounterResponse::fromArray($this->makeFhirEncounter());

        $this->assertCount(1, $response->identifiers);
        $this->assertSame('ENC-001', $response->identifiers[0]->value);
    }

    public function test_raw_contains_full_fhir_data(): void
    {
        $data     = $this->makeFhirEncounter();
        $response = EncounterResponse::fromArray($data);

        $this->assertSame($data, $response->raw);
    }

    public function test_id_is_null_when_absent(): void
    {
        $data = $this->makeFhirEncounter();
        unset($data['id']);

        $response = EncounterResponse::fromArray($data);

        $this->assertNull($response->id);
    }
}
