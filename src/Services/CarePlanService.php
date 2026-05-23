<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\CarePlan\CarePlanDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CarePlanResponse;

class CarePlanService extends AbstractResourceService
{
    public function create(CarePlanDTO $dto): CarePlanResponse
    {
        /** @var CarePlanResponse */
        return $this->doPost('/CarePlan', $dto->toArray(), fn(array $d) => CarePlanResponse::fromArray($d));
    }

    public function getById(string $id): CarePlanResponse
    {
        /** @var CarePlanResponse */
        return $this->doGet("/CarePlan/{$id}", [], fn(array $d) => CarePlanResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/CarePlan', ['subject' => $patientId], fn(array $d) => CarePlanResponse::fromArray($d));
    }

    public function update(string $id, CarePlanDTO $dto): CarePlanResponse
    {
        /** @var CarePlanResponse */
        return $this->doPut("/CarePlan/{$id}", $dto->toArray(), fn(array $d) => CarePlanResponse::fromArray($d));
    }
}
