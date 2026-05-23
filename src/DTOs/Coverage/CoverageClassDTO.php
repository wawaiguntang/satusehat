<?php

namespace Wawaiguntang\Satusehat\DTOs\Coverage;

/**
 * FHIR R4 - Coverage.class
 * @see https://www.hl7.org/fhir/coverage-definitions.html#Coverage.class
 *
 * Kelas kepesertaan asuransi.
 * Kode type menggunakan: http://terminology.hl7.org/CodeSystem/coverage-class
 *
 * Contoh kode:
 *  - group → kelompok kepesertaan (contoh: "ppu-pegawai-swasta")
 *  - class → kelas layanan (contoh: "1" = Kelas 1)
 *  - plan  → paket asuransi (contoh: "COV000004" = Ambulatory benefits)
 */
class CoverageClassDTO
{
    public function __construct(
        /** @var string Kode tipe (group/class/plan) */
        public readonly string $typeCode,

        /** @var string Display tipe (contoh: "Group", "Class", "Plan") */
        public readonly string $typeDisplay,

        /** @var string Nilai kelas */
        public readonly string $value,

        /** @var string Nama kelas */
        public readonly string $name,
    ) {}

    public function toArray(): array
    {
        return [
            'type'  => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/coverage-class',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'value' => $this->value,
            'name'  => $this->name,
        ];
    }
}
