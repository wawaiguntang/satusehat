<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\RelatedPerson\RelatedPersonDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\RelatedPersonResponse;

class RelatedPersonService extends AbstractResourceService
{
    public function create(RelatedPersonDTO $dto): RelatedPersonResponse
    {
        /** @var RelatedPersonResponse */
        return $this->doPost('/RelatedPerson', $dto->toArray(), fn(array $d) => RelatedPersonResponse::fromArray($d));
    }

    public function getById(string $id): RelatedPersonResponse
    {
        /** @var RelatedPersonResponse */
        return $this->doGet("/RelatedPerson/{$id}", [], fn(array $d) => RelatedPersonResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/RelatedPerson', ['patient' => $patientId], fn(array $d) => RelatedPersonResponse::fromArray($d));
    }

    public function searchByNik(string $nik): BundleResponse
    {
        return $this->doGetBundle(
            '/RelatedPerson',
            ['identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik],
            fn(array $d) => RelatedPersonResponse::fromArray($d),
        );
    }

    public function update(string $id, RelatedPersonDTO $dto): RelatedPersonResponse
    {
        /** @var RelatedPersonResponse */
        return $this->doPut("/RelatedPerson/{$id}", $dto->toArray(), fn(array $d) => RelatedPersonResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): RelatedPersonResponse
    {
        /** @var RelatedPersonResponse */
        return $this->doPatch("/RelatedPerson/{$id}", $operations, fn(array $d) => RelatedPersonResponse::fromArray($d));
    }
}
