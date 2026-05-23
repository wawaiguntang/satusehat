<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\MedicationRequest\MedicationRequestDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationRequestResponse;

class MedicationRequestService extends AbstractResourceService
{
    public function create(MedicationRequestDTO $dto): MedicationRequestResponse
    {
        /** @var MedicationRequestResponse */
        return $this->doPost('/MedicationRequest', $dto->toArray(), fn(array $d) => MedicationRequestResponse::fromArray($d));
    }

    public function getById(string $id): MedicationRequestResponse
    {
        /** @var MedicationRequestResponse */
        return $this->doGet("/MedicationRequest/{$id}", [], fn(array $d) => MedicationRequestResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/MedicationRequest', ['subject' => $patientId], fn(array $d) => MedicationRequestResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/MedicationRequest', ['encounter' => $encounterId], fn(array $d) => MedicationRequestResponse::fromArray($d));
    }

    public function update(string $id, MedicationRequestDTO $dto): MedicationRequestResponse
    {
        /** @var MedicationRequestResponse */
        return $this->doPut("/MedicationRequest/{$id}", $dto->toArray(), fn(array $d) => MedicationRequestResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): MedicationRequestResponse
    {
        /** @var MedicationRequestResponse */
        return $this->doPatch("/MedicationRequest/{$id}", $operations, fn(array $d) => MedicationRequestResponse::fromArray($d));
    }
}
