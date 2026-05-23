<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Immunization\ImmunizationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ImmunizationResponse;

class ImmunizationService extends AbstractResourceService
{
    public function create(ImmunizationDTO $dto): ImmunizationResponse
    {
        /** @var ImmunizationResponse */
        return $this->doPost('/Immunization', $dto->toArray(), fn(array $d) => ImmunizationResponse::fromArray($d));
    }

    public function getById(string $id): ImmunizationResponse
    {
        /** @var ImmunizationResponse */
        return $this->doGet("/Immunization/{$id}", [], fn(array $d) => ImmunizationResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Immunization', ['patient' => $patientId], fn(array $d) => ImmunizationResponse::fromArray($d));
    }

    public function update(string $id, ImmunizationDTO $dto): ImmunizationResponse
    {
        /** @var ImmunizationResponse */
        return $this->doPut("/Immunization/{$id}", $dto->toArray(), fn(array $d) => ImmunizationResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): ImmunizationResponse
    {
        /** @var ImmunizationResponse */
        return $this->doPatch("/Immunization/{$id}", $operations, fn(array $d) => ImmunizationResponse::fromArray($d));
    }
}
