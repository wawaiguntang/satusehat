<?php

namespace Wawaiguntang\Satusehat\DTOs\EpisodeOfCare;

use Wawaiguntang\Satusehat\Enums\EpisodeOfCare\EpisodeOfCareStatusEnum;

/**
 * FHIR R4 - EpisodeOfCare Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/EpisodeOfCare
 *
 * Merepresentasikan episode perawatan pasien (contoh: program TB).
 *
 * Operasi yang didukung:
 *  - POST  /EpisodeOfCare           → create
 *  - GET   /EpisodeOfCare/:id       → by ID
 *  - GET   /EpisodeOfCare?patient=  → search by patient ID
 *  - PUT   /EpisodeOfCare/:id       → update
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/episode-of-care/{Org_id}"
 * Field type.coding.system: "http://terminology.kemkes.go.id/CodeSystem/episodeofcare-type"
 * Contoh kode type: TB-SO (Tuberkulosis Sensitif Obat), TB-RO (Tuberkulosis Resisten Obat)
 */
class EpisodeOfCareDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var EpisodeOfCareStatusEnum Status episode */
        public readonly EpisodeOfCareStatusEnum $status,

        /** @var string Referensi Patient */
        public readonly string $patientReference,

        /** @var string Referensi Organization pengelola */
        public readonly string $managingOrganizationReference,

        /** @var string Tanggal mulai episode (YYYY-MM-DD) */
        public readonly string $periodStart,

        /**
         * @var array Identifier
         * Struktur: [['system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik EpisodeOfCare di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $patientDisplay = null,

        /** @var string|null Tanggal akhir episode (YYYY-MM-DD) */
        public readonly ?string $periodEnd = null,

        /** @var EpisodeOfCareStatusHistoryDTO[]|null Riwayat status */
        public readonly ?array $statusHistory = null,

        /**
         * @var array[]|null Tipe episode (SATUSEHAT-specific)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $type = null,

        /** @var EpisodeOfCareDiagnosisDTO[]|null Daftar diagnosis */
        public readonly ?array $diagnosis = null,

        /** @var string|null Referensi Practitioner care manager */
        public readonly ?string $careManagerReference = null,
    ) {
        $this->resourceType = 'EpisodeOfCare';
    }

    public function toArray(): array
    {
        $patient = ['reference' => $this->patientReference];
        if ($this->patientDisplay !== null) {
            $patient['display'] = $this->patientDisplay;
        }

        $period = ['start' => $this->periodStart];
        if ($this->periodEnd !== null) {
            $period['end'] = $this->periodEnd;
        }

        $data = [
            'resourceType'          => $this->resourceType,
            'identifier'            => $this->identifier,
            'status'                => $this->status->value,
            'patient'               => $patient,
            'managingOrganization'  => ['reference' => $this->managingOrganizationReference],
            'period'                => $period,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->statusHistory !== null) {
            $data['statusHistory'] = array_map(fn($s) => $s->toArray(), $this->statusHistory);
        }

        if ($this->type !== null) {
            $data['type'] = array_map(fn($t) => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/episodeofcare-type',
                        'code'    => $t['code'],
                        'display' => $t['display'],
                    ],
                ],
            ], $this->type);
        }

        if ($this->diagnosis !== null) {
            $data['diagnosis'] = array_map(fn($d) => $d->toArray(), $this->diagnosis);
        }

        if ($this->careManagerReference !== null) {
            $data['careManager'] = ['reference' => $this->careManagerReference];
        }

        return $data;
    }
}
