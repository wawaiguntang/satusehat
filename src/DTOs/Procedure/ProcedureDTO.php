<?php

namespace Wawaiguntang\Satusehat\DTOs\Procedure;

use Wawaiguntang\Satusehat\Enums\Procedure\ProcedureStatusEnum;

/**
 * FHIR R4 - Procedure Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Procedure
 *
 * Merepresentasikan tindakan medis / prosedur yang dilakukan kepada pasien.
 *
 * Operasi yang didukung:
 *  - POST  /Procedure             → create
 *  - GET   /Procedure/:id         → by ID
 *  - GET   /Procedure?subject=    → search by patient ID
 *  - GET   /Procedure?encounter=  → search by encounter ID
 *
 * Code system yang digunakan:
 *  - category : SNOMED CT (http://snomed.info/sct)
 *  - code     : ICD-9-CM (http://hl7.org/fhir/sid/icd-9-cm)
 *  - reasonCode: ICD-10 (http://hl7.org/fhir/sid/icd-10)
 *  - bodySite : SNOMED CT (http://snomed.info/sct)
 */
class ProcedureDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ProcedureStatusEnum Status prosedur */
        public readonly ProcedureStatusEnum $status,

        /** @var string Kode ICD-9-CM untuk prosedur (contoh: "87.44") */
        public readonly string $code,

        /** @var string Nama prosedur */
        public readonly string $codeDisplay,

        /** @var string Referensi Patient (contoh: "Patient/100000030009") */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Waktu mulai prosedur (ISO 8601 + timezone) */
        public readonly string $performedStart,

        /** @var string Waktu selesai prosedur (ISO 8601 + timezone) */
        public readonly string $performedEnd,

        /** @var ProcedurePerformerDTO[] Daftar pelaksana prosedur */
        public readonly array $performer,

        /** @var string|null ID unik Procedure di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Deskripsi tampilan encounter */
        public readonly ?string $encounterDisplay = null,

        /**
         * @var string|null Kode SNOMED CT untuk kategori prosedur
         * Contoh: "103693007" = Diagnostic procedure
         */
        public readonly ?string $categoryCode = null,

        /** @var string|null Display kategori (contoh: "Diagnostic procedure") */
        public readonly ?string $categoryDisplay = null,

        /**
         * @var array[]|null Alasan medis prosedur (ICD-10)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $reasonCode = null,

        /**
         * @var array[]|null Lokasi tubuh (SNOMED CT)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $bodySite = null,

        /** @var string[]|null Catatan tambahan tindakan */
        public readonly ?array $note = null,
    ) {
        $this->resourceType = 'Procedure';
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
            'resourceType'    => $this->resourceType,
            'status'          => $this->status->value,
            'code'            => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-9-cm',
                        'code'    => $this->code,
                        'display' => $this->codeDisplay,
                    ],
                ],
            ],
            'subject'         => $subject,
            'encounter'       => $encounter,
            'performedPeriod' => [
                'start' => $this->performedStart,
                'end'   => $this->performedEnd,
            ],
            'performer' => array_map(fn($p) => $p->toArray(), $this->performer),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->categoryCode !== null) {
            $data['category'] = [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $this->categoryCode,
                        'display' => $this->categoryDisplay ?? $this->categoryCode,
                    ],
                ],
                'text' => $this->categoryDisplay ?? $this->categoryCode,
            ];
        }

        if ($this->reasonCode !== null) {
            $data['reasonCode'] = array_map(fn($r) => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $r['code'],
                        'display' => $r['display'],
                    ],
                ],
            ], $this->reasonCode);
        }

        if ($this->bodySite !== null) {
            $data['bodySite'] = array_map(fn($b) => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $b['code'],
                        'display' => $b['display'],
                    ],
                ],
            ], $this->bodySite);
        }

        if ($this->note !== null) {
            $data['note'] = array_map(fn($n) => ['text' => $n], $this->note);
        }

        return $data;
    }
}
