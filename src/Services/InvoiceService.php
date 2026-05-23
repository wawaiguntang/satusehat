<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Invoice\InvoiceDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\InvoiceResponse;

class InvoiceService extends AbstractResourceService
{
    public function create(InvoiceDTO $dto): InvoiceResponse
    {
        /** @var InvoiceResponse */
        return $this->doPost('/Invoice', $dto->toArray(), fn(array $d) => InvoiceResponse::fromArray($d));
    }

    public function getById(string $id): InvoiceResponse
    {
        /** @var InvoiceResponse */
        return $this->doGet("/Invoice/{$id}", [], fn(array $d) => InvoiceResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Invoice', ['subject' => $patientId], fn(array $d) => InvoiceResponse::fromArray($d));
    }
}
