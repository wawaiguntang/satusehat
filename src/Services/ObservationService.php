<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Observation\ObservationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ObservationResponse;

class ObservationService extends AbstractResourceService
{
    public function create(ObservationDTO $dto): ObservationResponse
    {
        /** @var ObservationResponse */
        return $this->doPost('/Observation', $dto->toArray(), fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function getById(string $id): ObservationResponse
    {
        /** @var ObservationResponse */
        return $this->doGet("/Observation/{$id}", [], fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Observation', ['subject' => $patientId], fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/Observation', ['encounter' => $encounterId], fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function searchByCode(string $code): BundleResponse
    {
        return $this->doGetBundle('/Observation', ['code' => $code], fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function update(string $id, ObservationDTO $dto): ObservationResponse
    {
        /** @var ObservationResponse */
        return $this->doPut("/Observation/{$id}", $dto->toArray(), fn(array $d) => ObservationResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): ObservationResponse
    {
        /** @var ObservationResponse */
        return $this->doPatch("/Observation/{$id}", $operations, fn(array $d) => ObservationResponse::fromArray($d));
    }
}
