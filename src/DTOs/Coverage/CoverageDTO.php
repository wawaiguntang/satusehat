<?php

namespace Wawaiguntang\Satusehat\DTOs\Coverage;

use Wawaiguntang\Satusehat\Enums\Coverage\CoverageStatusEnum;

/**
 * FHIR R4 - Coverage Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Coverage
 *
 * Merepresentasikan data kepesertaan asuransi pasien (BPJS-K maupun asuransi swasta).
 *
 * Operasi yang didukung:
 *  - POST  /Coverage                → create
 *  - GET   /Coverage?patient=       → search by patient ID
 *  - GET   /Coverage?identifier=    → search by nomor kepesertaan
 *
 * Field identifier.system: "https://sys-ids.kemkes.go.id/insurance-subscriber/{Org_id}"
 * Field type.coding.system: "http://terminology.hl7.org/CodeSystem/v3-ActCode"
 * Contoh kode type:
 *  - PUBLICPOL → asuransi publik (BPJS-K)
 *  - SOCIAL    → program sosial
 *  - PRIV      → asuransi swasta
 *
 * Extension primaryCareProvider digunakan untuk BPJS-K (faskes primer):
 *  URL: "http://fhir.kemkes.go.id/r4/structureDefinition/primaryCareProvider"
 */
class CoverageDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var CoverageStatusEnum Status kepesertaan */
        public readonly CoverageStatusEnum $status,

        /** @var string Kode v3-ActCode tipe asuransi (contoh: "PUBLICPOL") */
        public readonly string $typeCode,

        /** @var string Display tipe asuransi (contoh: "public healthcare") */
        public readonly string $typeDisplay,

        /** @var string Nomor kepesertaan */
        public readonly string $subscriberId,

        /** @var string Referensi Patient penerima manfaat */
        public readonly string $beneficiaryReference,

        /** @var string[] Referensi Organization asuransi (payor) */
        public readonly array $payorReferences,

        /**
         * @var array Identifier kepesertaan
         * Struktur: [['system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik Coverage di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var CoverageClassDTO[]|null Kelas kepesertaan */
        public readonly ?array $class = null,

        /** @var string|null Referensi Patient pemegang polis (asuransi swasta) */
        public readonly ?string $policyHolderReference = null,

        /** @var string|null Referensi Patient peserta (asuransi swasta) */
        public readonly ?string $subscriberReference = null,

        /** @var string|null Referensi Organization faskes primer (BPJS-K extension) */
        public readonly ?string $primaryCareProviderReference = null,
    ) {
        $this->resourceType = 'Coverage';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => $this->identifier,
            'status'       => $this->status->value,
            'type'         => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'subscriberId' => $this->subscriberId,
            'beneficiary'  => ['reference' => $this->beneficiaryReference],
            'payor'        => array_map(fn($r) => ['reference' => $r], $this->payorReferences),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->policyHolderReference !== null) {
            $data['policyHolder'] = ['reference' => $this->policyHolderReference];
        }

        if ($this->subscriberReference !== null) {
            $data['subscriber'] = ['reference' => $this->subscriberReference];
        }

        if ($this->class !== null) {
            $data['class'] = array_map(fn($c) => $c->toArray(), $this->class);
        }

        if ($this->primaryCareProviderReference !== null) {
            $data['extension'] = [
                [
                    'url'            => 'http://fhir.kemkes.go.id/r4/structureDefinition/primaryCareProvider',
                    'valueReference' => ['reference' => $this->primaryCareProviderReference],
                ],
            ];
        }

        return $data;
    }
}
