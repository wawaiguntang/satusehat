<?php

namespace Wawaiguntang\Satusehat\DTOs\Observation;

/**
 * FHIR R4 - Observation.component
 * @see https://www.hl7.org/fhir/observation-definitions.html#Observation.component
 *
 * Digunakan untuk Observation multi-komponen, contoh:
 *  - Blood Pressure (55284-4): systolic (8480-6) + diastolic (8462-4)
 *
 * Kode menggunakan LOINC: http://loinc.org
 * Satuan menggunakan UCUM: http://unitsofmeasure.org
 */
class ObservationComponentDTO
{
    public function __construct(
        /** @var string Kode LOINC komponen (contoh: "8480-6" = Systolic BP) */
        public readonly string $loincCode,

        /** @var string Display kode LOINC */
        public readonly string $loincDisplay,

        /** @var float Nilai hasil pengukuran */
        public readonly float $value,

        /** @var string Satuan pengukuran (contoh: "mm[Hg]") */
        public readonly string $unit,

        /** @var string Kode UCUM (contoh: "mm[Hg]") */
        public readonly string $unitCode,
    ) {}

    public function toArray(): array
    {
        return [
            'code'          => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $this->loincCode,
                        'display' => $this->loincDisplay,
                    ],
                ],
            ],
            'valueQuantity' => [
                'value'  => $this->value,
                'unit'   => $this->unit,
                'system' => 'http://unitsofmeasure.org',
                'code'   => $this->unitCode,
            ],
        ];
    }
}
