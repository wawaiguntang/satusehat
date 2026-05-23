<?php

namespace Wawaiguntang\Satusehat\DTOs\AllergyIntolerance;

use Wawaiguntang\Satusehat\Enums\AllergyIntolerance\AllergyIntoleranceCategoryEnum;
use Wawaiguntang\Satusehat\Enums\AllergyIntolerance\AllergyIntoleranceClinicalStatusEnum;
use Wawaiguntang\Satusehat\Enums\AllergyIntolerance\AllergyIntoleranceVerificationStatusEnum;

/**
 * FHIR R4 - AllergyIntolerance Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/AllergyIntolerance
 *
 * Merepresentasikan alergi atau intoleransi pasien terhadap suatu zat.
 *
 * Operasi yang didukung:
 *  - POST  /AllergyIntolerance             → create
 *  - GET   /AllergyIntolerance/:id         → by ID
 *  - GET   /AllergyIntolerance?patient=    → search by patient ID
 *  - GET   /AllergyIntolerance?encounter=  → search by encounter ID
 *
 * Kode alergen menggunakan SNOMED CT: http://snomed.info/sct
 * Field identifier.system: "http://sys-ids.kemkes.go.id/allergy/{Org_id}"
 */
class AllergyIntoleranceDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var AllergyIntoleranceClinicalStatusEnum Status klinis */
        public readonly AllergyIntoleranceClinicalStatusEnum $clinicalStatus,

        /** @var string Display untuk clinicalStatus (contoh: "Active") */
        public readonly string $clinicalStatusDisplay,

        /** @var AllergyIntoleranceVerificationStatusEnum Status verifikasi */
        public readonly AllergyIntoleranceVerificationStatusEnum $verificationStatus,

        /** @var string Display untuk verificationStatus (contoh: "Confirmed") */
        public readonly string $verificationStatusDisplay,

        /** @var AllergyIntoleranceCategoryEnum[] Kategori alergi */
        public readonly array $category,

        /** @var string Kode SNOMED CT alergen */
        public readonly string $code,

        /** @var string Display alergen */
        public readonly string $codeDisplay,

        /** @var string Referensi Patient (field: patient, bukan subject) */
        public readonly string $patientReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal dicatat (ISO 8601 + timezone) */
        public readonly string $recordedDate,

        /** @var string Referensi Practitioner pencatat */
        public readonly string $recorderReference,

        /**
         * @var array Identifier
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik AllergyIntolerance di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $patientDisplay = null,

        /** @var string|null Deskripsi encounter */
        public readonly ?string $encounterDisplay = null,

        /** @var string|null Teks deskriptif alergen */
        public readonly ?string $codeText = null,
    ) {
        $this->resourceType = 'AllergyIntolerance';
    }

    public function toArray(): array
    {
        $patient = ['reference' => $this->patientReference];
        if ($this->patientDisplay !== null) {
            $patient['display'] = $this->patientDisplay;
        }

        $encounter = ['reference' => $this->encounterReference];
        if ($this->encounterDisplay !== null) {
            $encounter['display'] = $this->encounterDisplay;
        }

        $code = [
            'coding' => [
                [
                    'system'  => 'http://snomed.info/sct',
                    'code'    => $this->code,
                    'display' => $this->codeDisplay,
                ],
            ],
        ];
        if ($this->codeText !== null) {
            $code['text'] = $this->codeText;
        }

        $data = [
            'resourceType'       => $this->resourceType,
            'identifier'         => $this->identifier,
            'clinicalStatus'     => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical',
                        'code'    => $this->clinicalStatus->value,
                        'display' => $this->clinicalStatusDisplay,
                    ],
                ],
            ],
            'verificationStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/allergyintolerance-verification',
                        'code'    => $this->verificationStatus->value,
                        'display' => $this->verificationStatusDisplay,
                    ],
                ],
            ],
            'category'           => array_map(fn($c) => $c->value, $this->category),
            'code'               => $code,
            'patient'            => $patient,
            'encounter'          => $encounter,
            'recordedDate'       => $this->recordedDate,
            'recorder'           => ['reference' => $this->recorderReference],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
