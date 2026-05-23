<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\DiagnosticReport\DiagnosticReportDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\DiagnosticReportResponse;

class DiagnosticReportService extends AbstractResourceService
{
    public function create(DiagnosticReportDTO $dto): DiagnosticReportResponse
    {
        /** @var DiagnosticReportResponse */
        return $this->doPost('/DiagnosticReport', $dto->toArray(), fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }

    public function getById(string $id): DiagnosticReportResponse
    {
        /** @var DiagnosticReportResponse */
        return $this->doGet("/DiagnosticReport/{$id}", [], fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/DiagnosticReport', ['subject' => $patientId], fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/DiagnosticReport', ['encounter' => $encounterId], fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }

    public function update(string $id, DiagnosticReportDTO $dto): DiagnosticReportResponse
    {
        /** @var DiagnosticReportResponse */
        return $this->doPut("/DiagnosticReport/{$id}", $dto->toArray(), fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): DiagnosticReportResponse
    {
        /** @var DiagnosticReportResponse */
        return $this->doPatch("/DiagnosticReport/{$id}", $operations, fn(array $d) => DiagnosticReportResponse::fromArray($d));
    }
}
