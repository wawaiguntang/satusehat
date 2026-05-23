<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Patient\PatientDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PatientResponse;

class PatientService extends AbstractResourceService
{
    public function getByNik(string $nik): BundleResponse
    {
        return $this->doGetBundle(
            '/Patient',
            ['identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik],
            fn(array $d) => PatientResponse::fromArray($d),
        );
    }

    public function getByNikIbu(string $nikIbu, string $birthDate): BundleResponse
    {
        return $this->doGetBundle(
            '/Patient',
            [
                'identifier' => 'https://fhir.kemkes.go.id/id/nik-ibu|' . $nikIbu,
                'birthdate'  => $birthDate,
            ],
            fn(array $d) => PatientResponse::fromArray($d),
        );
    }

    public function getById(string $id): PatientResponse
    {
        /** @var PatientResponse */
        return $this->doGet("/Patient/{$id}", [], fn(array $d) => PatientResponse::fromArray($d));
    }

    public function getByIhsNumber(string $ihsNumber): BundleResponse
    {
        return $this->doGetBundle(
            '/Patient',
            ['identifier' => 'https://fhir.kemkes.go.id/id/ihs-number|' . $ihsNumber],
            fn(array $d) => PatientResponse::fromArray($d),
        );
    }

    public function searchByName(string $name, ?string $birthDate = null, ?string $gender = null): BundleResponse
    {
        $params = ['name' => $name];
        if ($birthDate !== null) {
            $params['birthdate'] = $birthDate;
        }
        if ($gender !== null) {
            $params['gender'] = $gender;
        }

        return $this->doGetBundle('/Patient', $params, fn(array $d) => PatientResponse::fromArray($d));
    }

    public function create(PatientDTO $dto): PatientResponse
    {
        /** @var PatientResponse */
        return $this->doPost('/Patient', $dto->toArray(), fn(array $d) => PatientResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): PatientResponse
    {
        /** @var PatientResponse */
        return $this->doPatch("/Patient/{$id}", $operations, fn(array $d) => PatientResponse::fromArray($d));
    }
}
