<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\ImagingStudy\ImagingStudyDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ImagingStudyResponse;

class ImagingStudyService extends AbstractResourceService
{
    public function create(ImagingStudyDTO $dto): ImagingStudyResponse
    {
        /** @var ImagingStudyResponse */
        return $this->doPost('/ImagingStudy', $dto->toArray(), fn(array $d) => ImagingStudyResponse::fromArray($d));
    }

    public function getById(string $id): ImagingStudyResponse
    {
        /** @var ImagingStudyResponse */
        return $this->doGet("/ImagingStudy/{$id}", [], fn(array $d) => ImagingStudyResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/ImagingStudy', ['subject' => $patientId], fn(array $d) => ImagingStudyResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/ImagingStudy', ['encounter' => $encounterId], fn(array $d) => ImagingStudyResponse::fromArray($d));
    }

    public function update(string $id, ImagingStudyDTO $dto): ImagingStudyResponse
    {
        /** @var ImagingStudyResponse */
        return $this->doPut("/ImagingStudy/{$id}", $dto->toArray(), fn(array $d) => ImagingStudyResponse::fromArray($d));
    }
}
