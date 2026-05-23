<?php

namespace Wawaiguntang\Satusehat\DTOs\MedicationDispense;

use Wawaiguntang\Satusehat\Enums\MedicationDispense\MedicationDispenseStatusEnum;
use Wawaiguntang\Satusehat\Shared\DTOs\MedicationDosageInstructionDTO;

/**
 * FHIR R4 - MedicationDispense Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationDispense
 *
 * Merepresentasikan penyerahan/pemberian obat kepada pasien di apotek.
 *
 * Operasi yang didukung:
 *  - POST  /MedicationDispense             → create
 *  - GET   /MedicationDispense/:id         → by ID
 *  - GET   /MedicationDispense?subject=    → search by patient ID
 *  - GET   /MedicationDispense?context=    → search by encounter ID
 *
 * Field category adalah object tunggal (bukan array) — berbeda dengan MedicationRequest.
 * Field context = referensi Encounter (berbeda dengan MedicationRequest yang pakai encounter).
 *
 * Field identifier menggunakan 2 system:
 *  - http://sys-ids.kemkes.go.id/prescription/{Org_id}       → nomor resep
 *  - http://sys-ids.kemkes.go.id/prescription-item/{Org_id}  → nomor item resep
 */
class MedicationDispenseDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var MedicationDispenseStatusEnum Status dispensing */
        public readonly MedicationDispenseStatusEnum $status,

        /** @var string Kode kategori (contoh: "outpatient") */
        public readonly string $categoryCode,

        /** @var string Display kategori (contoh: "Outpatient") */
        public readonly string $categoryDisplay,

        /** @var string Referensi Medication */
        public readonly string $medicationReference,

        /** @var string Display nama obat */
        public readonly string $medicationDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter (field: context) */
        public readonly string $contextReference,

        /** @var float Jumlah obat yang diserahkan */
        public readonly float $quantityValue,

        /** @var string Satuan jumlah (contoh: "TAB") */
        public readonly string $quantityCode,

        /** @var int Durasi suplai dalam hari */
        public readonly int $daysSupply,

        /** @var MedicationDosageInstructionDTO[] Instruksi dosis */
        public readonly array $dosageInstruction,

        /**
         * @var array Identifier dispensing
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik MedicationDispense di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /**
         * @var array[]|null Pelaksana dispensing
         * Struktur: [['reference' => string, 'display' => string|null], ...]
         */
        public readonly ?array $performer = null,

        /** @var string|null Referensi Location apotek */
        public readonly ?string $locationReference = null,

        /** @var string|null Display nama apotek */
        public readonly ?string $locationDisplay = null,

        /** @var string[]|null Referensi MedicationRequest yang diotorisasi */
        public readonly ?array $authorizingPrescriptionReferences = null,

        /** @var string|null Waktu obat disiapkan (ISO 8601) */
        public readonly ?string $whenPrepared = null,

        /** @var string|null Waktu obat diserahkan (ISO 8601) */
        public readonly ?string $whenHandedOver = null,
    ) {
        $this->resourceType = 'MedicationDispense';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $data = [
            'resourceType'        => $this->resourceType,
            'identifier'          => $this->identifier,
            'status'              => $this->status->value,
            'category'            => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category',
                        'code'    => $this->categoryCode,
                        'display' => $this->categoryDisplay,
                    ],
                ],
            ],
            'medicationReference' => [
                'reference' => $this->medicationReference,
                'display'   => $this->medicationDisplay,
            ],
            'subject'             => $subject,
            'context'             => ['reference' => $this->contextReference],
            'quantity'            => [
                'value'  => $this->quantityValue,
                'unit'   => $this->quantityCode,
                'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                'code'   => $this->quantityCode,
            ],
            'daysSupply'          => [
                'value'  => $this->daysSupply,
                'unit'   => 'Day',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'd',
            ],
            'dosageInstruction'   => array_map(fn($d) => $d->toArray(), $this->dosageInstruction),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->performer !== null) {
            $data['performer'] = array_map(function ($p) {
                $actor = ['reference' => $p['reference']];
                if (!empty($p['display'])) {
                    $actor['display'] = $p['display'];
                }
                return ['actor' => $actor];
            }, $this->performer);
        }

        if ($this->locationReference !== null) {
            $location = ['reference' => $this->locationReference];
            if ($this->locationDisplay !== null) {
                $location['display'] = $this->locationDisplay;
            }
            $data['location'] = $location;
        }

        if ($this->authorizingPrescriptionReferences !== null) {
            $data['authorizingPrescription'] = array_map(
                fn($ref) => ['reference' => $ref],
                $this->authorizingPrescriptionReferences
            );
        }

        if ($this->whenPrepared !== null) {
            $data['whenPrepared'] = $this->whenPrepared;
        }

        if ($this->whenHandedOver !== null) {
            $data['whenHandedOver'] = $this->whenHandedOver;
        }

        return $data;
    }
}
