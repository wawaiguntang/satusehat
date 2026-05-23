<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\AllergyIntolerance\AllergyIntoleranceDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\AllergyIntoleranceResponse;

class AllergyIntoleranceService extends AbstractResourceService
{
    public function create(AllergyIntoleranceDTO $dto): AllergyIntoleranceResponse
    {
        /** @var AllergyIntoleranceResponse */
        return $this->doPost('/AllergyIntolerance', $dto->toArray(), fn(array $d) => AllergyIntoleranceResponse::fromArray($d));
    }

    public function getById(string $id): AllergyIntoleranceResponse
    {
        /** @var AllergyIntoleranceResponse */
        return $this->doGet("/AllergyIntolerance/{$id}", [], fn(array $d) => AllergyIntoleranceResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/AllergyIntolerance', ['patient' => $patientId], fn(array $d) => AllergyIntoleranceResponse::fromArray($d));
    }

    public function update(string $id, AllergyIntoleranceDTO $dto): AllergyIntoleranceResponse
    {
        /** @var AllergyIntoleranceResponse */
        return $this->doPut("/AllergyIntolerance/{$id}", $dto->toArray(), fn(array $d) => AllergyIntoleranceResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): AllergyIntoleranceResponse
    {
        /** @var AllergyIntoleranceResponse */
        return $this->doPatch("/AllergyIntolerance/{$id}", $operations, fn(array $d) => AllergyIntoleranceResponse::fromArray($d));
    }
}
