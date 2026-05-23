<?php

namespace Wawaiguntang\Satusehat\DTOs\MedicationRequest;

use Wawaiguntang\Satusehat\Enums\MedicationRequest\MedicationRequestCategoryEnum;
use Wawaiguntang\Satusehat\Enums\MedicationRequest\MedicationRequestIntentEnum;
use Wawaiguntang\Satusehat\Shared\Enums\RequestPriorityEnum;
use Wawaiguntang\Satusehat\Enums\MedicationRequest\MedicationRequestStatusEnum;
use Wawaiguntang\Satusehat\Shared\DTOs\MedicationDosageInstructionDTO;

/**
 * FHIR R4 - MedicationRequest Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationRequest
 *
 * Merepresentasikan resep/permintaan pemberian obat untuk pasien.
 *
 * Operasi yang didukung:
 *  - POST  /MedicationRequest             → create
 *  - GET   /MedicationRequest/:id         → by ID
 *  - GET   /MedicationRequest?subject=    → search by patient ID
 *  - GET   /MedicationRequest?encounter=  → search by encounter ID
 *
 * Field identifier menggunakan 2 system:
 *  - http://sys-ids.kemkes.go.id/prescription/{Org_id}       → nomor resep
 *  - http://sys-ids.kemkes.go.id/prescription-item/{Org_id}  → nomor item resep
 *
 * courseOfTherapyType: http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy
 *  (continuous, acute, seasonal)
 */
class MedicationRequestDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var MedicationRequestStatusEnum Status resep */
        public readonly MedicationRequestStatusEnum $status,

        /** @var MedicationRequestIntentEnum Intent resep */
        public readonly MedicationRequestIntentEnum $intent,

        /** @var MedicationRequestCategoryEnum Kategori resep */
        public readonly MedicationRequestCategoryEnum $category,

        /** @var string Display kategori (contoh: "Outpatient") */
        public readonly string $categoryDisplay,

        /** @var RequestPriorityEnum Prioritas resep */
        public readonly RequestPriorityEnum $priority,

        /** @var string Referensi Medication (contoh: "Medication/uuid") */
        public readonly string $medicationReference,

        /** @var string Display nama obat */
        public readonly string $medicationDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal resep dibuat (YYYY-MM-DD) */
        public readonly string $authoredOn,

        /** @var string Referensi Practitioner penulis resep */
        public readonly string $requesterReference,

        /** @var MedicationDosageInstructionDTO[] Instruksi dosis */
        public readonly array $dosageInstruction,

        /** @var MedicationDispenseRequestDTO Informasi dispensing */
        public readonly MedicationDispenseRequestDTO $dispenseRequest,

        /**
         * @var array Identifier resep
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik MedicationRequest di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Nama tampilan penulis resep */
        public readonly ?string $requesterDisplay = null,

        /**
         * @var array[]|null Alasan resep (ICD-10)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $reasonCode = null,

        /** @var string|null Kode tipe terapi (contoh: "continuous") */
        public readonly ?string $courseOfTherapyCode = null,

        /** @var string|null Display tipe terapi */
        public readonly ?string $courseOfTherapyDisplay = null,
    ) {
        $this->resourceType = 'MedicationRequest';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $requester = ['reference' => $this->requesterReference];
        if ($this->requesterDisplay !== null) {
            $requester['display'] = $this->requesterDisplay;
        }

        $data = [
            'resourceType'        => $this->resourceType,
            'identifier'          => $this->identifier,
            'status'              => $this->status->value,
            'intent'              => $this->intent->value,
            'category'            => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/medicationrequest-category',
                            'code'    => $this->category->value,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'priority'            => $this->priority->value,
            'medicationReference' => [
                'reference' => $this->medicationReference,
                'display'   => $this->medicationDisplay,
            ],
            'subject'             => $subject,
            'encounter'           => ['reference' => $this->encounterReference],
            'authoredOn'          => $this->authoredOn,
            'requester'           => $requester,
            'dosageInstruction'   => array_map(fn($d) => $d->toArray(), $this->dosageInstruction),
            'dispenseRequest'     => $this->dispenseRequest->toArray(),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
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

        if ($this->courseOfTherapyCode !== null) {
            $data['courseOfTherapyType'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy',
                        'code'    => $this->courseOfTherapyCode,
                        'display' => $this->courseOfTherapyDisplay ?? $this->courseOfTherapyCode,
                    ],
                ],
            ];
        }

        return $data;
    }
}
