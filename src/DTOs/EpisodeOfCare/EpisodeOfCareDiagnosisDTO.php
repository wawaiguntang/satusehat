<?php

namespace Wawaiguntang\Satusehat\DTOs\EpisodeOfCare;

/**
 * FHIR R4 - EpisodeOfCare.diagnosis
 * @see https://www.hl7.org/fhir/episodeofcare-definitions.html#EpisodeOfCare.diagnosis
 *
 * Kode role menggunakan: http://terminology.hl7.org/CodeSystem/diagnosis-role
 * Contoh role: AD (Admission Diagnosis), DD (Discharged Diagnosis), CC (Chief Complaint), dll.
 */
class EpisodeOfCareDiagnosisDTO
{
    public function __construct(
        /** @var string Referensi Condition */
        public readonly string $conditionReference,

        /** @var int Urutan prioritas diagnosis */
        public readonly int $rank,

        /** @var string|null Display Condition */
        public readonly ?string $conditionDisplay = null,

        /** @var string|null Kode role diagnosis (contoh: "DD") */
        public readonly ?string $roleCode = null,

        /** @var string|null Display role diagnosis (contoh: "Discharged Diagnosis") */
        public readonly ?string $roleDisplay = null,
    ) {}

    public function toArray(): array
    {
        $condition = ['reference' => $this->conditionReference];
        if ($this->conditionDisplay !== null) {
            $condition['display'] = $this->conditionDisplay;
        }

        $data = [
            'condition' => $condition,
            'rank'      => $this->rank,
        ];

        if ($this->roleCode !== null) {
            $data['role'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/diagnosis-role',
                        'code'    => $this->roleCode,
                        'display' => $this->roleDisplay ?? $this->roleCode,
                    ],
                ],
            ];
        }

        return $data;
    }
}
