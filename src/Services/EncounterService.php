<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Encounter\EncounterDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EncounterResponse;

class EncounterService extends AbstractResourceService
{
    public function create(EncounterDTO $dto): EncounterResponse
    {
        /** @var EncounterResponse */
        return $this->doPost('/Encounter', $dto->toArray(), fn(array $d) => EncounterResponse::fromArray($d));
    }

    public function getById(string $id): EncounterResponse
    {
        /** @var EncounterResponse */
        return $this->doGet("/Encounter/{$id}", [], fn(array $d) => EncounterResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle(
            '/Encounter',
            ['subject' => $patientId],
            fn(array $d) => EncounterResponse::fromArray($d),
        );
    }

    public function update(string $id, EncounterDTO $dto): EncounterResponse
    {
        /** @var EncounterResponse */
        return $this->doPut("/Encounter/{$id}", $dto->toArray(), fn(array $d) => EncounterResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): EncounterResponse
    {
        /** @var EncounterResponse */
        return $this->doPatch("/Encounter/{$id}", $operations, fn(array $d) => EncounterResponse::fromArray($d));
    }

    public function getEverything(string $id): BundleResponse
    {
        return $this->doGetBundle(
            "/Encounter/{$id}/\$everything",
            [],
            fn(array $d) => EncounterResponse::fromArray($d),
        );
    }
}
