<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Medication\MedicationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationResponse;

class MedicationService extends AbstractResourceService
{
    public function create(MedicationDTO $dto): MedicationResponse
    {
        /** @var MedicationResponse */
        return $this->doPost('/Medication', $dto->toArray(), fn(array $d) => MedicationResponse::fromArray($d));
    }

    public function getById(string $id): MedicationResponse
    {
        /** @var MedicationResponse */
        return $this->doGet("/Medication/{$id}", [], fn(array $d) => MedicationResponse::fromArray($d));
    }

    public function searchByCode(string $code): BundleResponse
    {
        return $this->doGetBundle('/Medication', ['code' => $code], fn(array $d) => MedicationResponse::fromArray($d));
    }

    public function update(string $id, MedicationDTO $dto): MedicationResponse
    {
        /** @var MedicationResponse */
        return $this->doPut("/Medication/{$id}", $dto->toArray(), fn(array $d) => MedicationResponse::fromArray($d));
    }
}
