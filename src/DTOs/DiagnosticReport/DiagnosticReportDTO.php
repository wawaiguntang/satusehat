<?php

namespace Wawaiguntang\Satusehat\DTOs\DiagnosticReport;

use Wawaiguntang\Satusehat\Enums\DiagnosticReport\DiagnosticReportCategoryEnum;
use Wawaiguntang\Satusehat\Enums\DiagnosticReport\DiagnosticReportStatusEnum;

/**
 * FHIR R4 - DiagnosticReport Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/DiagnosticReport
 *
 * Merepresentasikan laporan hasil pemeriksaan diagnostik (lab, radiologi, dll.).
 *
 * Operasi yang didukung:
 *  - POST  /DiagnosticReport             → create
 *  - GET   /DiagnosticReport/:id         → by ID
 *  - GET   /DiagnosticReport?subject=    → search by patient ID
 *  - GET   /DiagnosticReport?encounter=  → search by encounter ID
 *
 * Kode laporan menggunakan LOINC: http://loinc.org
 * Kode kategori menggunakan v2-0074: http://terminology.hl7.org/CodeSystem/v2-0074
 * Kesimpulan menggunakan SNOMED CT: http://snomed.info/sct
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/diagnostic/{Org_id}/{jenis}"
 */
class DiagnosticReportDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var DiagnosticReportStatusEnum Status laporan */
        public readonly DiagnosticReportStatusEnum $status,

        /** @var DiagnosticReportCategoryEnum Kategori laporan */
        public readonly DiagnosticReportCategoryEnum $category,

        /** @var string Display kategori (contoh: "Microbiology") */
        public readonly string $categoryDisplay,

        /** @var string Kode LOINC jenis pemeriksaan */
        public readonly string $code,

        /** @var string Display jenis pemeriksaan */
        public readonly string $codeDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Waktu efektif pemeriksaan (ISO 8601) */
        public readonly string $effectiveDateTime,

        /** @var string Waktu laporan diterbitkan (ISO 8601) */
        public readonly string $issued,

        /**
         * @var array[] Pelaksana pemeriksaan (Practitioner dan/atau Organization)
         * Struktur: [['reference' => string], ...]
         */
        public readonly array $performer,

        /**
         * @var array Identifier laporan
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik DiagnosticReport di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string[]|null Referensi Observation hasil pemeriksaan */
        public readonly ?array $resultReferences = null,

        /** @var string[]|null Referensi Specimen sampel */
        public readonly ?array $specimenReferences = null,

        /**
         * @var array[]|null Kode kesimpulan (SNOMED CT)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $conclusionCode = null,

        /** @var string|null Teks kesimpulan */
        public readonly ?string $conclusion = null,
    ) {
        $this->resourceType = 'DiagnosticReport';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => $this->identifier,
            'status'       => $this->status->value,
            'category'     => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0074',
                            'code'    => $this->category->value,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'code'              => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $this->code,
                        'display' => $this->codeDisplay,
                    ],
                ],
            ],
            'subject'           => ['reference' => $this->subjectReference],
            'encounter'         => ['reference' => $this->encounterReference],
            'effectiveDateTime' => $this->effectiveDateTime,
            'issued'            => $this->issued,
            'performer'         => array_map(fn($p) => ['reference' => $p], $this->performer),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->resultReferences !== null) {
            $data['result'] = array_map(fn($r) => ['reference' => $r], $this->resultReferences);
        }

        if ($this->specimenReferences !== null) {
            $data['specimen'] = array_map(fn($s) => ['reference' => $s], $this->specimenReferences);
        }

        if ($this->conclusionCode !== null) {
            $data['conclusionCode'] = array_map(fn($c) => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $c['code'],
                        'display' => $c['display'],
                    ],
                ],
            ], $this->conclusionCode);
        }

        if ($this->conclusion !== null) {
            $data['conclusion'] = $this->conclusion;
        }

        return $data;
    }
}
