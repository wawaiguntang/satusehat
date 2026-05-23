<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\ClaimResponse\ClaimResponseDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponseResponse;

class ClaimResponseService extends AbstractResourceService
{
    public function create(ClaimResponseDTO $dto): ClaimResponseResponse
    {
        /** @var ClaimResponseResponse */
        return $this->doPost('/ClaimResponse', $dto->toArray(), fn(array $d) => ClaimResponseResponse::fromArray($d));
    }

    public function getById(string $id): ClaimResponseResponse
    {
        /** @var ClaimResponseResponse */
        return $this->doGet("/ClaimResponse/{$id}", [], fn(array $d) => ClaimResponseResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/ClaimResponse', ['patient' => $patientId], fn(array $d) => ClaimResponseResponse::fromArray($d));
    }
}
