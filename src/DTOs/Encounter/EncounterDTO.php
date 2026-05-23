<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

use Wawaiguntang\Satusehat\Enums\Encounter\EncounterClassEnum;
use Wawaiguntang\Satusehat\Enums\Encounter\EncounterStatusEnum;

/**
 * FHIR R4 - Encounter Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Encounter
 *
 * Merepresentasikan satu kunjungan/episode pelayanan pasien di fasilitas kesehatan.
 *
 * Operasi yang didukung:
 *  - POST  /Encounter               → create (wajib: status, class, subject, participant, period, location, serviceProvider, identifier)
 *  - GET   /Encounter/:id           → by ID
 *  - GET   /Encounter?subject=      → search by patient ID
 *  - PUT   /Encounter/:id           → full update (wajib: id + semua field)
 *  - PATCH /Encounter/:id           → partial update via JSON Patch (RFC 6902)
 *
 * Alur status kunjungan:
 *  arrived → in-progress → finished (+ hospitalization.dischargeDisposition)
 *
 * Field identifier.system menggunakan pola:
 *  http://sys-ids.kemkes.go.id/encounter/{Org_id}
 *
 * Datetime format: ISO 8601 dengan timezone (contoh: "2022-06-14T07:00:00+07:00")
 */
class EncounterDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var EncounterStatusEnum Status kunjungan saat ini */
        public readonly EncounterStatusEnum $status,

        /** @var EncounterClassEnum Kelas kunjungan (AMB=rawat jalan, IMP=rawat inap, EMER=IGD) */
        public readonly EncounterClassEnum $class,

        /** @var string Display teks untuk class (contoh: "ambulatory") */
        public readonly string $classDisplay,

        /** @var string Referensi Patient (contoh: "Patient/100000030009") */
        public readonly string $subjectReference,

        /** @var EncounterParticipantDTO[] Daftar tenaga kesehatan yang terlibat */
        public readonly array $participant,

        /** @var string Waktu mulai kunjungan (ISO 8601 + timezone) */
        public readonly string $periodStart,

        /** @var EncounterLocationDTO[] Lokasi pelayanan */
        public readonly array $location,

        /** @var string Referensi Organization penyelenggara (contoh: "Organization/10000004") */
        public readonly string $serviceProviderReference,

        /**
         * @var array Identifier kunjungan
         * Struktur: ['system' => string, 'value' => string]
         * system: "http://sys-ids.kemkes.go.id/encounter/{orgId}"
         */
        public readonly array $identifier,

        /** @var string|null ID unik Encounter di SATUSEHAT (wajib untuk PUT) */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Waktu selesai kunjungan (ISO 8601 + timezone) */
        public readonly ?string $periodEnd = null,

        /** @var EncounterStatusHistoryDTO[]|null Riwayat perubahan status */
        public readonly ?array $statusHistory = null,

        /** @var EncounterDiagnosisDTO[]|null Daftar diagnosis kunjungan */
        public readonly ?array $diagnosis = null,

        /** @var EncounterHospitalizationDTO|null Informasi kepulangan pasien */
        public readonly ?EncounterHospitalizationDTO $hospitalization = null,
    ) {
        $this->resourceType = 'Encounter';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $period = ['start' => $this->periodStart];
        if ($this->periodEnd !== null) {
            $period['end'] = $this->periodEnd;
        }

        $data = [
            'resourceType'    => $this->resourceType,
            'status'          => $this->status->value,
            'class'           => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => $this->class->value,
                'display' => $this->classDisplay,
            ],
            'subject'         => $subject,
            'participant'     => array_map(fn($p) => $p->toArray(), $this->participant),
            'period'          => $period,
            'location'        => array_map(fn($l) => $l->toArray(), $this->location),
            'serviceProvider' => ['reference' => $this->serviceProviderReference],
            'identifier'      => $this->identifier,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->statusHistory !== null) {
            $data['statusHistory'] = array_map(fn($s) => $s->toArray(), $this->statusHistory);
        }

        if ($this->diagnosis !== null) {
            $data['diagnosis'] = array_map(fn($d) => $d->toArray(), $this->diagnosis);
        }

        if ($this->hospitalization !== null) {
            $data['hospitalization'] = $this->hospitalization->toArray();
        }

        return $data;
    }
}
