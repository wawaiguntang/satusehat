<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\EpisodeOfCare\EpisodeOfCareDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EpisodeOfCareResponse;

class EpisodeOfCareService extends AbstractResourceService
{
    public function create(EpisodeOfCareDTO $dto): EpisodeOfCareResponse
    {
        /** @var EpisodeOfCareResponse */
        return $this->doPost('/EpisodeOfCare', $dto->toArray(), fn(array $d) => EpisodeOfCareResponse::fromArray($d));
    }

    public function getById(string $id): EpisodeOfCareResponse
    {
        /** @var EpisodeOfCareResponse */
        return $this->doGet("/EpisodeOfCare/{$id}", [], fn(array $d) => EpisodeOfCareResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/EpisodeOfCare', ['patient' => $patientId], fn(array $d) => EpisodeOfCareResponse::fromArray($d));
    }

    public function update(string $id, EpisodeOfCareDTO $dto): EpisodeOfCareResponse
    {
        /** @var EpisodeOfCareResponse */
        return $this->doPut("/EpisodeOfCare/{$id}", $dto->toArray(), fn(array $d) => EpisodeOfCareResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): EpisodeOfCareResponse
    {
        /** @var EpisodeOfCareResponse */
        return $this->doPatch("/EpisodeOfCare/{$id}", $operations, fn(array $d) => EpisodeOfCareResponse::fromArray($d));
    }
}
