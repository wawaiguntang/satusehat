<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Specimen\SpecimenDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\SpecimenResponse;

class SpecimenService extends AbstractResourceService
{
    public function create(SpecimenDTO $dto): SpecimenResponse
    {
        /** @var SpecimenResponse */
        return $this->doPost('/Specimen', $dto->toArray(), fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function getById(string $id): SpecimenResponse
    {
        /** @var SpecimenResponse */
        return $this->doGet("/Specimen/{$id}", [], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Specimen', ['subject' => $patientId], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function searchByRequest(string $requestId): BundleResponse
    {
        return $this->doGetBundle('/Specimen', ['request' => $requestId], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function searchByCollector(string $patientId, string $collectorId): BundleResponse
    {
        return $this->doGetBundle('/Specimen', ['subject' => $patientId, 'collector' => $collectorId], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function searchBySubjectAndDate(string $patientId, string $collectedDate): BundleResponse
    {
        return $this->doGetBundle('/Specimen', ['subject' => $patientId, 'collected' => $collectedDate], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function searchByIdentifierAndRequest(string $identifier, string $requestId): BundleResponse
    {
        return $this->doGetBundle('/Specimen', ['identifier' => $identifier, 'request' => $requestId], fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function update(string $id, SpecimenDTO $dto): SpecimenResponse
    {
        /** @var SpecimenResponse */
        return $this->doPut("/Specimen/{$id}", $dto->toArray(), fn(array $d) => SpecimenResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): SpecimenResponse
    {
        /** @var SpecimenResponse */
        return $this->doPatch("/Specimen/{$id}", $operations, fn(array $d) => SpecimenResponse::fromArray($d));
    }
}
