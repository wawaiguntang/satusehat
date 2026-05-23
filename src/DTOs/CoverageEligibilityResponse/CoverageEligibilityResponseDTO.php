<?php

namespace Wawaiguntang\Satusehat\DTOs\CoverageEligibilityResponse;

use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityOutcomeEnum;
use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityResponseStatusEnum;

/**
 * FHIR R4 - CoverageEligibilityResponse Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/CoverageEligibilityResponse
 *
 * Merepresentasikan respon verifikasi eligibilitas kepesertaan asuransi (SEP/Surat Eligibilitas Peserta).
 *
 * Operasi yang didukung:
 *  - POST  /CoverageEligibilityResponse           → create
 *  - GET   /CoverageEligibilityResponse?patient=  → search by patient ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/claim-number/{Org_id}"
 * Field identifier.type.coding.system: "http://terminology.hl7.org/CodeSystem/v2-0203"
 * Kode identifier type: NIIP (National Insurance Payor Identifier)
 */
class CoverageEligibilityResponseDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var EligibilityResponseStatusEnum Status respon */
        public readonly EligibilityResponseStatusEnum $status,

        /** @var string[] Tujuan (contoh: ["validation"]) */
        public readonly array $purpose,

        /** @var string Referensi Patient */
        public readonly string $patientReference,

        /** @var string Datetime dibuat (ISO 8601 + timezone) */
        public readonly string $created,

        /** @var string Referensi Organization faskes pemohon */
        public readonly string $requestorReference,

        /** @var string Referensi CoverageEligibilityRequest */
        public readonly string $requestReference,

        /** @var EligibilityOutcomeEnum Hasil verifikasi */
        public readonly EligibilityOutcomeEnum $outcome,

        /** @var string Keterangan status peserta (contoh: "Peserta aktif") */
        public readonly string $disposition,

        /** @var string Referensi Organization asuransi */
        public readonly string $insurerReference,

        /** @var CoverageEligibilityResponseInsuranceDTO[] Informasi manfaat */
        public readonly array $insurance,

        /**
         * @var array Identifier SEP/nomor klaim
         * Struktur: [['use' => string, 'system' => string, 'value' => string, 'periodStart' => string, 'periodEnd' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik CoverageEligibilityResponse di SATUSEHAT */
        public readonly ?string $id = null,
    ) {
        $this->resourceType = 'CoverageEligibilityResponse';
    }

    public function toArray(): array
    {
        $identifiers = array_map(function ($ident) {
            $item = [
                'use'    => $ident['use'],
                'system' => $ident['system'],
                'value'  => $ident['value'],
                'type'   => [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0203',
                            'code'    => 'NIIP',
                            'display' => 'National Insurance Payor Identifier (Payor)',
                        ],
                    ],
                ],
            ];
            if (!empty($ident['periodStart'])) {
                $item['period'] = ['start' => $ident['periodStart']];
                if (!empty($ident['periodEnd'])) {
                    $item['period']['end'] = $ident['periodEnd'];
                }
            }
            return $item;
        }, $this->identifier);

        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => $identifiers,
            'status'       => $this->status->value,
            'purpose'      => $this->purpose,
            'patient'      => ['reference' => $this->patientReference],
            'created'      => $this->created,
            'requestor'    => ['reference' => $this->requestorReference],
            'request'      => ['reference' => $this->requestReference],
            'outcome'      => $this->outcome->value,
            'disposition'  => $this->disposition,
            'insurer'      => ['reference' => $this->insurerReference],
            'insurance'    => array_map(fn($i) => $i->toArray(), $this->insurance),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
