<?php

namespace Wawaiguntang\Satusehat\DTOs\Condition;

use Wawaiguntang\Satusehat\Enums\Condition\ConditionCategoryEnum;
use Wawaiguntang\Satusehat\Enums\Condition\ConditionClinicalStatusEnum;
use Wawaiguntang\Satusehat\Enums\Condition\ConditionCodeSystemEnum;

/**
 * FHIR R4 - Condition Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Condition
 *
 * Merepresentasikan kondisi klinis / diagnosis pasien yang terkait dengan suatu kunjungan.
 *
 * Operasi yang didukung:
 *  - POST  /Condition             → create
 *  - GET   /Condition/:id         → by ID
 *  - GET   /Condition?subject=    → search by patient ID
 *  - GET   /Condition?encounter=  → search by encounter ID
 *
 * Code system yang didukung untuk field code:
 *  - ICD-10  : http://hl7.org/fhir/sid/icd-10
 *  - SNOMED CT: http://snomed.info/sct
 */
class ConditionDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ConditionClinicalStatusEnum Status klinis kondisi */
        public readonly ConditionClinicalStatusEnum $clinicalStatus,

        /** @var string Display teks untuk clinicalStatus (contoh: "Active") */
        public readonly string $clinicalStatusDisplay,

        /** @var ConditionCategoryEnum Kategori kondisi */
        public readonly ConditionCategoryEnum $category,

        /** @var string Display teks untuk category (contoh: "Encounter Diagnosis") */
        public readonly string $categoryDisplay,

        /** @var ConditionCodeSystemEnum Code system untuk kode diagnosis */
        public readonly ConditionCodeSystemEnum $codeSystem,

        /** @var string Kode diagnosis (contoh: "K35.8" untuk ICD-10, "359746009" untuk SNOMED CT) */
        public readonly string $code,

        /** @var string Nama/display diagnosis */
        public readonly string $codeDisplay,

        /** @var string Referensi Patient (contoh: "Patient/100000030009") */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter (contoh: "Encounter/{{uuid}}") */
        public readonly string $encounterReference,

        /** @var string|null ID unik Condition di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Deskripsi tampilan encounter */
        public readonly ?string $encounterDisplay = null,
    ) {
        $this->resourceType = 'Condition';
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
            'resourceType'   => $this->resourceType,
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-clinical',
                        'code'    => $this->clinicalStatus->value,
                        'display' => $this->clinicalStatusDisplay,
                    ],
                ],
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/condition-category',
                            'code'    => $this->category->value,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => $this->codeSystem->value,
                        'code'    => $this->code,
                        'display' => $this->codeDisplay,
                    ],
                ],
            ],
            'subject'   => $subject,
            'encounter' => $encounter,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
