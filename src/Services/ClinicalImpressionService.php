<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\ClinicalImpression\ClinicalImpressionDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClinicalImpressionResponse;

class ClinicalImpressionService extends AbstractResourceService
{
    public function create(ClinicalImpressionDTO $dto): ClinicalImpressionResponse
    {
        /** @var ClinicalImpressionResponse */
        return $this->doPost('/ClinicalImpression', $dto->toArray(), fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }

    public function getById(string $id): ClinicalImpressionResponse
    {
        /** @var ClinicalImpressionResponse */
        return $this->doGet("/ClinicalImpression/{$id}", [], fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/ClinicalImpression', ['subject' => $patientId], fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/ClinicalImpression', ['encounter' => $encounterId], fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }

    public function update(string $id, ClinicalImpressionDTO $dto): ClinicalImpressionResponse
    {
        /** @var ClinicalImpressionResponse */
        return $this->doPut("/ClinicalImpression/{$id}", $dto->toArray(), fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): ClinicalImpressionResponse
    {
        /** @var ClinicalImpressionResponse */
        return $this->doPatch("/ClinicalImpression/{$id}", $operations, fn(array $d) => ClinicalImpressionResponse::fromArray($d));
    }
}
