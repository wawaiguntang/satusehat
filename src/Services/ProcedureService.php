<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Procedure\ProcedureDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ProcedureResponse;

class ProcedureService extends AbstractResourceService
{
    public function create(ProcedureDTO $dto): ProcedureResponse
    {
        /** @var ProcedureResponse */
        return $this->doPost('/Procedure', $dto->toArray(), fn(array $d) => ProcedureResponse::fromArray($d));
    }

    public function getById(string $id): ProcedureResponse
    {
        /** @var ProcedureResponse */
        return $this->doGet("/Procedure/{$id}", [], fn(array $d) => ProcedureResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Procedure', ['subject' => $patientId], fn(array $d) => ProcedureResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/Procedure', ['encounter' => $encounterId], fn(array $d) => ProcedureResponse::fromArray($d));
    }

    public function update(string $id, ProcedureDTO $dto): ProcedureResponse
    {
        /** @var ProcedureResponse */
        return $this->doPut("/Procedure/{$id}", $dto->toArray(), fn(array $d) => ProcedureResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): ProcedureResponse
    {
        /** @var ProcedureResponse */
        return $this->doPatch("/Procedure/{$id}", $operations, fn(array $d) => ProcedureResponse::fromArray($d));
    }
}
