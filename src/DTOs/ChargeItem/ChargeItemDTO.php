<?php

namespace Wawaiguntang\Satusehat\DTOs\ChargeItem;

use Wawaiguntang\Satusehat\Enums\ChargeItem\ChargeItemStatusEnum;

/**
 * FHIR R4 - ChargeItem Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/ChargeItem
 *
 * Merepresentasikan item biaya tindakan medis yang dapat ditagihkan ke pasien/asuransi.
 *
 * Operasi yang didukung:
 *  - POST  /ChargeItem            → create
 *  - GET   /ChargeItem?account=   → search by account ID
 *  - GET   /ChargeItem?subject=   → search by patient ID
 *
 * Kode tindakan menggunakan KPTL SATUSEHAT: http://terminology.kemkes.go.id/CodeSystem/kptl
 * Extension SATUSEHAT:
 *  - unitPrice:  https://fhir.kemkes.go.id/r4/StructureDefinition/unitPrice
 *  - totalPrice: https://fhir.kemkes.go.id/r4/StructureDefinition/totalPrice
 * Mata uang: IDR
 */
class ChargeItemDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ChargeItemStatusEnum Status item biaya */
        public readonly ChargeItemStatusEnum $status,

        /** @var string Kode KPTL tindakan */
        public readonly string $kptlCode,

        /** @var string Display tindakan */
        public readonly string $kptlDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $contextReference,

        /** @var string Datetime mulai tindakan (ISO 8601 + timezone) */
        public readonly string $occurrencePeriodStart,

        /** @var string Datetime akhir tindakan (ISO 8601 + timezone) */
        public readonly string $occurrencePeriodEnd,

        /** @var ChargeItemPerformerDTO[] Pelaksana tindakan */
        public readonly array $performer,

        /** @var float Jumlah/kuantitas tindakan */
        public readonly float $quantity,

        /** @var string[] Referensi Account */
        public readonly array $accountReferences,

        /** @var string|null ID unik ChargeItem di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var float|null Harga satuan tindakan (IDR) */
        public readonly ?float $unitPrice = null,

        /** @var float|null Total harga tindakan (IDR) */
        public readonly ?float $totalPrice = null,
    ) {
        $this->resourceType = 'ChargeItem';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'    => $this->resourceType,
            'status'          => $this->status->value,
            'code'            => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/kptl',
                        'code'    => $this->kptlCode,
                        'display' => $this->kptlDisplay,
                    ],
                ],
            ],
            'subject'         => ['reference' => $this->subjectReference],
            'context'         => ['reference' => $this->contextReference],
            'occurrencePeriod' => [
                'start' => $this->occurrencePeriodStart,
                'end'   => $this->occurrencePeriodEnd,
            ],
            'performer'       => array_map(fn($p) => $p->toArray(), $this->performer),
            'quantity'        => ['value' => $this->quantity],
            'account'         => array_map(fn($r) => ['reference' => $r], $this->accountReferences),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        $extensions = [];
        if ($this->unitPrice !== null) {
            $extensions[] = [
                'url'        => 'https://fhir.kemkes.go.id/r4/StructureDefinition/unitPrice',
                'valueMoney' => [
                    'value'    => $this->unitPrice,
                    'currency' => 'IDR',
                ],
            ];
        }
        if ($this->totalPrice !== null) {
            $extensions[] = [
                'url'        => 'https://fhir.kemkes.go.id/r4/StructureDefinition/totalPrice',
                'valueMoney' => [
                    'value'    => $this->totalPrice,
                    'currency' => 'IDR',
                ],
            ];
        }
        if (!empty($extensions)) {
            $data['extension'] = $extensions;
        }

        return $data;
    }
}
