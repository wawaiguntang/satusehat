<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Claim\ClaimDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponse;

class ClaimService extends AbstractResourceService
{
    public function create(ClaimDTO $dto): ClaimResponse
    {
        /** @var ClaimResponse */
        return $this->doPost('/Claim', $dto->toArray(), fn(array $d) => ClaimResponse::fromArray($d));
    }

    public function getById(string $id): ClaimResponse
    {
        /** @var ClaimResponse */
        return $this->doGet("/Claim/{$id}", [], fn(array $d) => ClaimResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Claim', ['patient' => $patientId], fn(array $d) => ClaimResponse::fromArray($d));
    }

    public function searchByIdentifier(string $identifier): BundleResponse
    {
        return $this->doGetBundle('/Claim', ['identifier' => $identifier], fn(array $d) => ClaimResponse::fromArray($d));
    }
}
