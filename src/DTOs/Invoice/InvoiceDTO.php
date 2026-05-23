<?php

namespace Wawaiguntang\Satusehat\DTOs\Invoice;

use Wawaiguntang\Satusehat\Enums\Invoice\InvoiceStatusEnum;

/**
 * FHIR R4 - Invoice Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Invoice
 *
 * Merepresentasikan tagihan layanan medis kepada pasien/asuransi.
 * Setiap line item mereferensikan ChargeItem dengan komponen harga dalam IDR.
 *
 * Operasi yang didukung:
 *  - POST  /Invoice           → create
 *  - GET   /Invoice/:id       → by ID
 *  - GET   /Invoice?subject=  → search by patient ID
 */
class InvoiceDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var InvoiceStatusEnum Status invoice */
        public readonly InvoiceStatusEnum $status,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Datetime dibuat (ISO 8601 + timezone) */
        public readonly string $date,

        /** @var string Referensi Organization penerbit */
        public readonly string $issuerReference,

        /** @var string Referensi Account */
        public readonly string $accountReference,

        /** @var InvoiceLineItemDTO[] Daftar item tagihan */
        public readonly array $lineItem,

        /** @var string|null ID unik Invoice di SATUSEHAT */
        public readonly ?string $id = null,
    ) {
        $this->resourceType = 'Invoice';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'status'       => $this->status->value,
            'subject'      => ['reference' => $this->subjectReference],
            'date'         => $this->date,
            'issuer'       => ['reference' => $this->issuerReference],
            'account'      => ['reference' => $this->accountReference],
            'lineItem'     => array_map(fn($l) => $l->toArray(), $this->lineItem),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
