<?php

namespace Wawaiguntang\Satusehat\DTOs\Composition;

use Wawaiguntang\Satusehat\Enums\Composition\CompositionStatusEnum;

/**
 * FHIR R4 - Composition Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Composition
 *
 * Merepresentasikan dokumen medis terstruktur (resume medis, catatan edukasi, dll.)
 * yang berisi kumpulan informasi klinis terkait satu kunjungan.
 *
 * Operasi yang didukung:
 *  - POST  /Composition             → create
 *  - GET   /Composition/:id         → by ID
 *  - GET   /Composition?subject=    → search by patient ID
 *  - GET   /Composition?encounter=  → search by encounter ID
 *
 * Kode type dan category menggunakan LOINC (http://loinc.org).
 * Field identifier adalah object tunggal (bukan array).
 * Field identifier.system: "http://sys-ids.kemkes.go.id/composition/{Org_id}"
 */
class CompositionDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string Nilai identifier dokumen (contoh: "P20240001") */
        public readonly string $identifierValue,

        /**
         * @var string System identifier
         * Format: "http://sys-ids.kemkes.go.id/composition/{orgId}"
         */
        public readonly string $identifierSystem,

        /** @var CompositionStatusEnum Status dokumen */
        public readonly CompositionStatusEnum $status,

        /** @var string Kode LOINC untuk tipe dokumen (contoh: "18842-5") */
        public readonly string $typeCode,

        /** @var string Display untuk tipe dokumen (contoh: "Discharge summary") */
        public readonly string $typeDisplay,

        /** @var string Kode LOINC untuk kategori (contoh: "LP173421-1") */
        public readonly string $categoryCode,

        /** @var string Display untuk kategori (contoh: "Report") */
        public readonly string $categoryDisplay,

        /** @var string Referensi Patient (contoh: "Patient/100000030009") */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal dokumen dibuat (format: YYYY-MM-DD) */
        public readonly string $date,

        /**
         * @var array[] Daftar penulis dokumen
         * Struktur: [['reference' => string, 'display' => string], ...]
         */
        public readonly array $author,

        /** @var string Judul dokumen (contoh: "Resume Medis Rawat Jalan") */
        public readonly string $title,

        /** @var string Referensi Organization penyimpan dokumen */
        public readonly string $custodianReference,

        /** @var CompositionSectionDTO[] Seksi-seksi konten dokumen */
        public readonly array $section,

        /** @var string|null ID unik Composition di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Deskripsi tampilan encounter */
        public readonly ?string $encounterDisplay = null,
    ) {
        $this->resourceType = 'Composition';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $encounter = ['reference' => $this->encounterReference];
        if ($this->encounterDisplay !== null) {
            $encounter['display'] = $this->encounterDisplay;
        }

        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => [
                'system' => $this->identifierSystem,
                'value'  => $this->identifierValue,
            ],
            'status'    => $this->status->value,
            'type'      => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://loinc.org',
                            'code'    => $this->categoryCode,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'subject'   => $subject,
            'encounter' => $encounter,
            'date'      => $this->date,
            'author'    => $this->author,
            'title'     => $this->title,
            'custodian' => ['reference' => $this->custodianReference],
            'section'   => array_map(fn($s) => $s->toArray(), $this->section),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
