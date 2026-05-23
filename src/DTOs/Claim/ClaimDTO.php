<?php

namespace Wawaiguntang\Satusehat\DTOs\Claim;

use Wawaiguntang\Satusehat\Enums\Claim\ClaimStatusEnum;
use Wawaiguntang\Satusehat\Enums\Claim\ClaimUseEnum;

/**
 * FHIR R4 - Claim Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Claim
 *
 * Merepresentasikan data klaim asuransi yang diajukan oleh faskes ke asuransi.
 *
 * Operasi yang didukung:
 *  - POST  /Claim           → create
 *  - GET   /Claim/:id       → by ID
 *  - GET   /Claim?patient=  → search by patient ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/claim-number/{Org_id}"
 * Kode type menggunakan: http://terminology.hl7.org/CodeSystem/claim-type
 * Contoh: institutional, oral, pharmacy, professional, vision
 * Kode priority menggunakan: http://terminology.hl7.org/CodeSystem/processpriority
 * Contoh: normal, stat, deferred
 */
class ClaimDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ClaimStatusEnum Status klaim */
        public readonly ClaimStatusEnum $status,

        /** @var string Kode tipe klaim (contoh: "institutional") */
        public readonly string $typeCode,

        /** @var ClaimUseEnum Penggunaan klaim */
        public readonly ClaimUseEnum $use,

        /** @var string Referensi Patient */
        public readonly string $patientReference,

        /** @var string Datetime mulai periode klaim (ISO 8601) */
        public readonly string $billablePeriodStart,

        /** @var string Datetime akhir periode klaim (ISO 8601) */
        public readonly string $billablePeriodEnd,

        /** @var string Datetime dibuat (ISO 8601) */
        public readonly string $created,

        /** @var string Referensi Organization asuransi */
        public readonly string $insurerReference,

        /** @var string Referensi Organization faskes */
        public readonly string $providerReference,

        /** @var ClaimInsuranceDTO[] Data coverage/asuransi */
        public readonly array $insurance,

        /**
         * @var array Identifier klaim
         * Struktur: [['system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik Claim di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Referensi Practitioner yang menginput */
        public readonly ?string $entererReference = null,

        /** @var string|null Kode prioritas proses (contoh: "normal") */
        public readonly ?string $priorityCode = null,

        /** @var string|null Kode payee type (contoh: "provider") */
        public readonly ?string $payeeTypeCode = null,

        /** @var string|null Referensi payee party */
        public readonly ?string $payeePartyReference = null,

        /** @var string|null Referensi Location fasilitas */
        public readonly ?string $facilityReference = null,

        /** @var ClaimDiagnosisDTO[]|null Daftar diagnosis */
        public readonly ?array $diagnosis = null,

        /** @var ClaimItemDTO[]|null Daftar item klaim */
        public readonly ?array $item = null,
    ) {
        $this->resourceType = 'Claim';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'   => $this->resourceType,
            'identifier'     => $this->identifier,
            'status'         => $this->status->value,
            'type'           => [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/claim-type',
                        'code'   => $this->typeCode,
                    ],
                ],
            ],
            'use'            => $this->use->value,
            'patient'        => ['reference' => $this->patientReference],
            'billablePeriod' => [
                'start' => $this->billablePeriodStart,
                'end'   => $this->billablePeriodEnd,
            ],
            'created'        => $this->created,
            'insurer'        => ['reference' => $this->insurerReference],
            'provider'       => ['reference' => $this->providerReference],
            'insurance'      => array_map(fn($i) => $i->toArray(), $this->insurance),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->entererReference !== null) {
            $data['enterer'] = ['reference' => $this->entererReference];
        }

        if ($this->priorityCode !== null) {
            $data['priority'] = [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/processpriority',
                        'code'   => $this->priorityCode,
                    ],
                ],
            ];
        }

        if ($this->payeeTypeCode !== null) {
            $payee = [
                'type' => [
                    'coding' => [
                        [
                            'system' => 'http://terminology.hl7.org/CodeSystem/payeetype',
                            'code'   => $this->payeeTypeCode,
                        ],
                    ],
                ],
            ];
            if ($this->payeePartyReference !== null) {
                $payee['party'] = ['reference' => $this->payeePartyReference];
            }
            $data['payee'] = $payee;
        }

        if ($this->facilityReference !== null) {
            $data['facility'] = ['reference' => $this->facilityReference];
        }

        if ($this->diagnosis !== null) {
            $data['diagnosis'] = array_map(fn($d) => $d->toArray(), $this->diagnosis);
        }

        if ($this->item !== null) {
            $data['item'] = array_map(fn($i) => $i->toArray(), $this->item);
        }

        return $data;
    }
}
