<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Composition\CompositionDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CompositionResponse;

class CompositionService extends AbstractResourceService
{
    public function create(CompositionDTO $dto): CompositionResponse
    {
        /** @var CompositionResponse */
        return $this->doPost('/Composition', $dto->toArray(), fn(array $d) => CompositionResponse::fromArray($d));
    }

    public function getById(string $id): CompositionResponse
    {
        /** @var CompositionResponse */
        return $this->doGet("/Composition/{$id}", [], fn(array $d) => CompositionResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Composition', ['subject' => $patientId], fn(array $d) => CompositionResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/Composition', ['encounter' => $encounterId], fn(array $d) => CompositionResponse::fromArray($d));
    }

    public function update(string $id, CompositionDTO $dto): CompositionResponse
    {
        /** @var CompositionResponse */
        return $this->doPut("/Composition/{$id}", $dto->toArray(), fn(array $d) => CompositionResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): CompositionResponse
    {
        /** @var CompositionResponse */
        return $this->doPatch("/Composition/{$id}", $operations, fn(array $d) => CompositionResponse::fromArray($d));
    }
}
