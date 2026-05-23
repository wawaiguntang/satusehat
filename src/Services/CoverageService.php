<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Coverage\CoverageDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageResponse;

class CoverageService extends AbstractResourceService
{
    public function create(CoverageDTO $dto): CoverageResponse
    {
        /** @var CoverageResponse */
        return $this->doPost('/Coverage', $dto->toArray(), fn(array $d) => CoverageResponse::fromArray($d));
    }

    public function getById(string $id): CoverageResponse
    {
        /** @var CoverageResponse */
        return $this->doGet("/Coverage/{$id}", [], fn(array $d) => CoverageResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Coverage', ['beneficiary' => $patientId], fn(array $d) => CoverageResponse::fromArray($d));
    }

    public function searchByPatientAndIdentifier(string $patientId, string $identifier): BundleResponse
    {
        return $this->doGetBundle('/Coverage', ['patient' => $patientId, 'identifier' => $identifier], fn(array $d) => CoverageResponse::fromArray($d));
    }

    public function update(string $id, CoverageDTO $dto): CoverageResponse
    {
        /** @var CoverageResponse */
        return $this->doPut("/Coverage/{$id}", $dto->toArray(), fn(array $d) => CoverageResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): CoverageResponse
    {
        /** @var CoverageResponse */
        return $this->doPatch("/Coverage/{$id}", $operations, fn(array $d) => CoverageResponse::fromArray($d));
    }
}
