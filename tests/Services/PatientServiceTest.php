<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PatientResponse;
use Wawaiguntang\Satusehat\Services\PatientService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class PatientServiceTest extends ServiceTestCase
{
    private function makeService(): PatientService
    {
        return new PatientService($this->client);
    }

    private function patientData(string $id = 'P001'): array
    {
        return [
            'resourceType' => 'Patient',
            'id'           => $id,
            'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-01T00:00:00Z'],
            'active'       => true,
            'gender'       => 'male',
            'birthDate'    => '1990-05-20',
            'name'         => [['use' => 'official', 'text' => 'John Doe']],
            'identifier'   => [
                ['system' => 'https://fhir.kemkes.go.id/id/nik', 'value' => '3201234567890001'],
            ],
        ];
    }

    public function test_get_by_nik_returns_bundle(): void
    {
        $this->respond([
            'resourceType' => 'Bundle',
            'total'        => 1,
            'entry'        => [['resource' => $this->patientData()]],
        ]);

        $bundle = $this->makeService()->getByNik('3201234567890001');

        $this->assertInstanceOf(BundleResponse::class, $bundle);
        $this->assertSame(1, $bundle->total);

        $patient = $bundle->first();
        $this->assertInstanceOf(PatientResponse::class, $patient);
        $this->assertSame('P001', $patient->id);
        $this->assertSame('3201234567890001', $patient->nik);
        $this->assertSame('John Doe', $patient->name);
    }

    public function test_get_by_nik_sends_correct_identifier_param(): void
    {
        $this->respond(['resourceType' => 'Bundle', 'total' => 0, 'entry' => []]);

        $this->makeService()->getByNik('3201234567890001');

        $this->assertStringContainsString('identifier=', $this->lastUri());
        $this->assertStringContainsString('3201234567890001', $this->lastUri());
    }

    public function test_get_by_id_returns_patient_response(): void
    {
        $this->respond($this->patientData('P-999'));

        $patient = $this->makeService()->getById('P-999');

        $this->assertInstanceOf(PatientResponse::class, $patient);
        $this->assertSame('P-999', $patient->id);
        $this->assertSame('male', $patient->gender);
    }

    public function test_get_by_nik_ibu_sends_nik_ibu_identifier(): void
    {
        $this->respond(['resourceType' => 'Bundle', 'total' => 1, 'entry' => [['resource' => $this->patientData('P-BAYI')]]]);

        $this->makeService()->getByNikIbu('9104025209000006', '2024-12-09');

        $this->assertStringContainsString('nik-ibu', $this->lastUri());
        $this->assertStringContainsString('9104025209000006', $this->lastUri());
        $this->assertStringContainsString('birthdate=2024-12-09', $this->lastUri());
    }

    public function test_get_by_ihs_number_sends_ihs_number_identifier(): void
    {
        $this->respond(['resourceType' => 'Bundle', 'total' => 1, 'entry' => [['resource' => $this->patientData()]]]);

        $this->makeService()->getByIhsNumber('P20394967125');

        $this->assertStringContainsString('ihs-number', $this->lastUri());
        $this->assertStringContainsString('P20394967125', $this->lastUri());
    }

    public function test_search_by_name_sends_name_param(): void
    {
        $this->respond(['resourceType' => 'Bundle', 'total' => 1, 'entry' => [['resource' => $this->patientData()]]]);

        $this->makeService()->searchByName('Salsabilla Anjani', '2001-04-16', 'female');

        $this->assertStringContainsString('name=', $this->lastUri());
        $this->assertStringContainsString('birthdate=2001-04-16', $this->lastUri());
        $this->assertStringContainsString('gender=female', $this->lastUri());
    }

    public function test_search_by_name_without_optional_params(): void
    {
        $this->respond(['resourceType' => 'Bundle', 'total' => 0, 'entry' => []]);

        $this->makeService()->searchByName('John');

        $this->assertStringContainsString('name=', $this->lastUri());
        $this->assertStringNotContainsString('birthdate=', $this->lastUri());
        $this->assertStringNotContainsString('gender=', $this->lastUri());
    }

    public function test_create_sends_post(): void
    {
        $this->respond($this->patientData('P-NEW'));
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Patient\PatientDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Patient']);

        $response = $this->makeService()->create($dto);

        $this->assertInstanceOf(PatientResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_patch_sends_patch_method(): void
    {
        $this->respond($this->patientData());

        $this->makeService()->patch('P001', [['op' => 'replace', 'path' => '/gender', 'value' => 'female']]);

        $this->assertSame('PATCH', $this->lastMethod());
        $this->assertStringContainsString('/Patient/P001', $this->lastUri());
    }
}
