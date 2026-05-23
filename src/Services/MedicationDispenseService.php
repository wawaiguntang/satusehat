<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\MedicationDispense\MedicationDispenseDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationDispenseResponse;

class MedicationDispenseService extends AbstractResourceService
{
    public function create(MedicationDispenseDTO $dto): MedicationDispenseResponse
    {
        /** @var MedicationDispenseResponse */
        return $this->doPost('/MedicationDispense', $dto->toArray(), fn(array $d) => MedicationDispenseResponse::fromArray($d));
    }

    public function getById(string $id): MedicationDispenseResponse
    {
        /** @var MedicationDispenseResponse */
        return $this->doGet("/MedicationDispense/{$id}", [], fn(array $d) => MedicationDispenseResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/MedicationDispense', ['subject' => $patientId], fn(array $d) => MedicationDispenseResponse::fromArray($d));
    }

    public function update(string $id, MedicationDispenseDTO $dto): MedicationDispenseResponse
    {
        /** @var MedicationDispenseResponse */
        return $this->doPut("/MedicationDispense/{$id}", $dto->toArray(), fn(array $d) => MedicationDispenseResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): MedicationDispenseResponse
    {
        /** @var MedicationDispenseResponse */
        return $this->doPatch("/MedicationDispense/{$id}", $operations, fn(array $d) => MedicationDispenseResponse::fromArray($d));
    }
}
