<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\ServiceRequest\ServiceRequestDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ServiceRequestResponse;

class ServiceRequestService extends AbstractResourceService
{
    public function create(ServiceRequestDTO $dto): ServiceRequestResponse
    {
        /** @var ServiceRequestResponse */
        return $this->doPost('/ServiceRequest', $dto->toArray(), fn(array $d) => ServiceRequestResponse::fromArray($d));
    }

    public function getById(string $id): ServiceRequestResponse
    {
        /** @var ServiceRequestResponse */
        return $this->doGet("/ServiceRequest/{$id}", [], fn(array $d) => ServiceRequestResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/ServiceRequest', ['subject' => $patientId], fn(array $d) => ServiceRequestResponse::fromArray($d));
    }

    public function searchByEncounter(string $encounterId): BundleResponse
    {
        return $this->doGetBundle('/ServiceRequest', ['encounter' => $encounterId], fn(array $d) => ServiceRequestResponse::fromArray($d));
    }

    public function searchByReferralNumber(string $identifier): BundleResponse
    {
        return $this->doGetBundle('/ServiceRequest', ['identifier' => $identifier], fn(array $d) => ServiceRequestResponse::fromArray($d));
    }

    public function update(string $id, ServiceRequestDTO $dto): ServiceRequestResponse
    {
        /** @var ServiceRequestResponse */
        return $this->doPut("/ServiceRequest/{$id}", $dto->toArray(), fn(array $d) => ServiceRequestResponse::fromArray($d));
    }
}
