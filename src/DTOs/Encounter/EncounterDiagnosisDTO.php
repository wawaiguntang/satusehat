<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

use Wawaiguntang\Satusehat\Enums\Encounter\DiagnosisRoleEnum;

/**
 * FHIR R4 - Encounter.diagnosis
 * @see https://www.hl7.org/fhir/encounter-definitions.html#Encounter.diagnosis
 *
 * Diagnosis yang terkait dengan kunjungan ini (biasanya Condition reference).
 */
class EncounterDiagnosisDTO
{
    public function __construct(
        /** @var string Referensi Condition (contoh: "Condition/4bbbe654-...") */
        public readonly string $conditionReference,

        /** @var DiagnosisRoleEnum Peran diagnosis (DD = Discharge, AD = Admission, dll) */
        public readonly DiagnosisRoleEnum $use,

        /** @var string Display teks untuk peran diagnosis */
        public readonly string $useDisplay,

        /** @var int Urutan prioritas diagnosis (1 = primer) */
        public readonly int $rank = 1,

        /** @var string|null Nama tampilan kondisi */
        public readonly ?string $conditionDisplay = null,
    ) {}

    public function toArray(): array
    {
        $condition = ['reference' => $this->conditionReference];
        if ($this->conditionDisplay !== null) {
            $condition['display'] = $this->conditionDisplay;
        }

        return [
            'condition' => $condition,
            'use'       => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/diagnosis-role',
                        'code'    => $this->use->value,
                        'display' => $this->useDisplay,
                    ],
                ],
            ],
            'rank'      => $this->rank,
        ];
    }
}
