<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Condition\ConditionDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ConditionResponse;

class ConditionService extends AbstractResourceService
{
    public function create(ConditionDTO $dto): ConditionResponse
    {
        /** @var ConditionResponse */
        return $this->doPost('/Condition', $dto->toArray(), fn(array $d) => ConditionResponse::fromArray($d));
    }

    public function getById(string $id): ConditionResponse
    {
        /** @var ConditionResponse */
        return $this->doGet("/Condition/{$id}", [], fn(array $d) => ConditionResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Condition', ['subject' => $patientId], fn(array $d) => ConditionResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/Condition', ['encounter' => $encounterId], fn(array $d) => ConditionResponse::fromArray($d));
    }

    public function update(string $id, ConditionDTO $dto): ConditionResponse
    {
        /** @var ConditionResponse */
        return $this->doPut("/Condition/{$id}", $dto->toArray(), fn(array $d) => ConditionResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): ConditionResponse
    {
        /** @var ConditionResponse */
        return $this->doPatch("/Condition/{$id}", $operations, fn(array $d) => ConditionResponse::fromArray($d));
    }
}
