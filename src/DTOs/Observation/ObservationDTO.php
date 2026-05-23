<?php

namespace Wawaiguntang\Satusehat\DTOs\Observation;

use Wawaiguntang\Satusehat\Enums\Observation\ObservationCategoryEnum;
use Wawaiguntang\Satusehat\Enums\Observation\ObservationStatusEnum;

/**
 * FHIR R4 - Observation Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Observation
 *
 * Merepresentasikan hasil pengukuran/pemeriksaan klinis, termasuk Tanda-Tanda Vital (TTV).
 *
 * Operasi yang didukung:
 *  - POST  /Observation             → create
 *  - GET   /Observation/:id         → by ID
 *  - GET   /Observation?subject=    → search by patient ID
 *  - GET   /Observation?encounter=  → search by encounter ID
 *
 * Kode pengukuran menggunakan LOINC: http://loinc.org
 * Contoh kode TTV LOINC yang umum:
 *  - 8867-4  = Heart rate (nadi)
 *  - 9279-1  = Respiratory rate (napas)
 *  - 8310-5  = Body temperature (suhu)
 *  - 8480-6  = Systolic blood pressure
 *  - 8462-4  = Diastolic blood pressure
 *  - 55284-4 = Blood pressure systolic and diastolic (multi-komponen)
 *  - 29463-7 = Body weight
 *  - 8302-2  = Body height
 *  - 39156-5 = BMI
 *
 * Untuk Observation tunggal: isi `valueQuantity`, kosongkan `component`.
 * Untuk Observation multi-komponen (contoh: Blood Pressure): isi `component[]`, kosongkan `valueQuantity`.
 */
class ObservationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ObservationStatusEnum Status observasi */
        public readonly ObservationStatusEnum $status,

        /** @var ObservationCategoryEnum Kategori observasi */
        public readonly ObservationCategoryEnum $category,

        /** @var string Display kategori (contoh: "Vital Signs") */
        public readonly string $categoryDisplay,

        /** @var string Kode LOINC jenis pengukuran */
        public readonly string $loincCode,

        /** @var string Display jenis pengukuran */
        public readonly string $loincDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string[] Referensi Practitioner pelaksana */
        public readonly array $performerReferences,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal pengukuran (YYYY-MM-DD atau ISO 8601) */
        public readonly string $effectiveDateTime,

        /** @var string Datetime diterbitkan (ISO 8601 + timezone) */
        public readonly string $issued,

        /** @var string|null ID unik Observation di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Display encounter */
        public readonly ?string $encounterDisplay = null,

        /**
         * @var float|null Nilai hasil pengukuran (untuk Observation tunggal)
         * Jika diisi, `component` harus null.
         */
        public readonly ?float $valueQuantityValue = null,

        /** @var string|null Satuan pengukuran (contoh: "beats/minute") */
        public readonly ?string $valueQuantityUnit = null,

        /** @var string|null Kode UCUM satuan (contoh: "/min") */
        public readonly ?string $valueQuantityCode = null,

        /**
         * @var ObservationComponentDTO[]|null Komponen hasil (untuk Observation multi-nilai)
         * Jika diisi, `valueQuantity` harus null.
         * Contoh: Blood Pressure = [systolic, diastolic]
         */
        public readonly ?array $component = null,
    ) {
        $this->resourceType = 'Observation';
    }

    public function toArray(): array
    {
        $encounter = ['reference' => $this->encounterReference];
        if ($this->encounterDisplay !== null) {
            $encounter['display'] = $this->encounterDisplay;
        }

        $data = [
            'resourceType'    => $this->resourceType,
            'status'          => $this->status->value,
            'category'        => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/observation-category',
                            'code'    => $this->category->value,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'code'            => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $this->loincCode,
                        'display' => $this->loincDisplay,
                    ],
                ],
            ],
            'subject'         => ['reference' => $this->subjectReference],
            'performer'       => array_map(fn($r) => ['reference' => $r], $this->performerReferences),
            'encounter'       => $encounter,
            'effectiveDateTime' => $this->effectiveDateTime,
            'issued'          => $this->issued,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->valueQuantityValue !== null) {
            $data['valueQuantity'] = [
                'value'  => $this->valueQuantityValue,
                'unit'   => $this->valueQuantityUnit,
                'system' => 'http://unitsofmeasure.org',
                'code'   => $this->valueQuantityCode,
            ];
        }

        if ($this->component !== null) {
            $data['component'] = array_map(fn($c) => $c->toArray(), $this->component);
        }

        return $data;
    }
}
