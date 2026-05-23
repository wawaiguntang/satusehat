<?php

namespace Wawaiguntang\Satusehat\DTOs\ClaimResponse;

use Wawaiguntang\Satusehat\Enums\Claim\ClaimStatusEnum;
use Wawaiguntang\Satusehat\Enums\Claim\ClaimUseEnum;
use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityOutcomeEnum;

/**
 * FHIR R4 - ClaimResponse Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/ClaimResponse
 *
 * Merepresentasikan respon/penilaian klaim dari pihak asuransi.
 *
 * Operasi yang didukung:
 *  - POST  /ClaimResponse           → create
 *  - GET   /ClaimResponse/:id       → by ID
 *  - GET   /ClaimResponse?patient=  → search by patient ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/claim-number/{Org_id}"
 * Kode payeeType menggunakan: http://terminology.hl7.org/CodeSystem/payeetype
 */
class ClaimResponseDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ClaimStatusEnum Status respon */
        public readonly ClaimStatusEnum $status,

        /** @var string Kode tipe klaim (contoh: "institutional") */
        public readonly string $typeCode,

        /** @var string Display tipe klaim */
        public readonly string $typeDisplay,

        /** @var ClaimUseEnum Penggunaan */
        public readonly ClaimUseEnum $use,

        /** @var string Referensi Patient */
        public readonly string $patientReference,

        /** @var string Datetime dibuat (ISO 8601) */
        public readonly string $created,

        /** @var string Referensi Organization asuransi */
        public readonly string $insurerReference,

        /** @var string Referensi Organization faskes pemohon */
        public readonly string $requestorReference,

        /** @var string Referensi Claim */
        public readonly string $requestReference,

        /** @var EligibilityOutcomeEnum Hasil pemrosesan */
        public readonly EligibilityOutcomeEnum $outcome,

        /** @var ClaimResponseAdjudicationDTO[] Hasil adjudikasi */
        public readonly array $adjudication,

        /**
         * @var array Identifier
         * Struktur: [['system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik ClaimResponse di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Kode payee type (contoh: "provider") */
        public readonly ?string $payeeTypeCode = null,

        /** @var string|null Display payee type */
        public readonly ?string $payeeTypeDisplay = null,

        /** @var ClaimResponseTotalDTO[]|null Total adjudikasi */
        public readonly ?array $total = null,

        /** @var ClaimResponsePaymentDTO|null Informasi pembayaran */
        public readonly ?ClaimResponsePaymentDTO $payment = null,
    ) {
        $this->resourceType = 'ClaimResponse';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'status'       => $this->status->value,
            'identifier'   => $this->identifier,
            'type'         => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/claim-type',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'use'          => $this->use->value,
            'patient'      => ['reference' => $this->patientReference],
            'created'      => $this->created,
            'insurer'      => ['reference' => $this->insurerReference],
            'requestor'    => ['reference' => $this->requestorReference],
            'request'      => ['reference' => $this->requestReference],
            'outcome'      => $this->outcome->value,
            'adjudication' => array_map(fn($a) => $a->toArray(), $this->adjudication),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->payeeTypeCode !== null) {
            $data['payeeType'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/payeetype',
                        'code'    => $this->payeeTypeCode,
                        'display' => $this->payeeTypeDisplay ?? $this->payeeTypeCode,
                    ],
                ],
            ];
        }

        if ($this->total !== null) {
            $data['total'] = array_map(fn($t) => $t->toArray(), $this->total);
        }

        if ($this->payment !== null) {
            $data['payment'] = $this->payment->toArray();
        }

        return $data;
    }
}
