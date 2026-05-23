<?php

namespace Wawaiguntang\Satusehat\DTOs\Medication;

use Wawaiguntang\Satusehat\Enums\Medication\MedicationStatusEnum;
use Wawaiguntang\Satusehat\Enums\Medication\MedicationTypeEnum;

/**
 * FHIR R4 - Medication Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Medication
 *
 * Merepresentasikan sediaan obat yang akan diresepkan atau diberikan kepada pasien.
 *
 * Operasi yang didukung:
 *  - POST  /Medication             → create
 *  - GET   /Medication/:id         → by ID
 *  - GET   /Medication?code=       → search by KFA code
 *  - GET   /Medication?identifier= → search by identifier
 *
 * Kode obat menggunakan KFA (Kode Farmasi dan Alat Kesehatan):
 *  http://sys-ids.kemkes.go.id/kfa
 *
 * Form sediaan menggunakan code system Kemenkes:
 *  http://terminology.kemkes.go.id/CodeSystem/medication-form
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/medication/{Org_id}"
 */
class MedicationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string Kode KFA obat */
        public readonly string $kfaCode,

        /** @var string Nama lengkap obat */
        public readonly string $kfaDisplay,

        /** @var MedicationStatusEnum Status obat */
        public readonly MedicationStatusEnum $status,

        /** @var string Kode bentuk sediaan (contoh: "BS023") */
        public readonly string $formCode,

        /** @var string Display bentuk sediaan (contoh: "Kaplet Salut Selaput") */
        public readonly string $formDisplay,

        /** @var MedicationIngredientDTO[] Daftar bahan aktif */
        public readonly array $ingredient,

        /** @var MedicationTypeEnum Tipe obat untuk extension SATUSEHAT */
        public readonly MedicationTypeEnum $medicationType,

        /** @var string Display tipe obat (contoh: "Non-compound") */
        public readonly string $medicationTypeDisplay,

        /** @var string|null ID unik Medication di SATUSEHAT */
        public readonly ?string $id = null,

        /**
         * @var array[]|null Identifier obat
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly ?array $identifier = null,

        /** @var string|null Referensi Organization produsen */
        public readonly ?string $manufacturerReference = null,
    ) {
        $this->resourceType = 'Medication';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'meta'         => [
                'profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Medication'],
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => $this->kfaCode,
                        'display' => $this->kfaDisplay,
                    ],
                ],
            ],
            'status' => $this->status->value,
            'form'   => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-form',
                        'code'    => $this->formCode,
                        'display' => $this->formDisplay,
                    ],
                ],
            ],
            'ingredient' => array_map(fn($i) => $i->toArray(), $this->ingredient),
            'extension'  => [
                [
                    'url'                => 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType',
                    'valueCodeableConcept' => [
                        'coding' => [
                            [
                                'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-type',
                                'code'    => $this->medicationType->value,
                                'display' => $this->medicationTypeDisplay,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->identifier !== null) {
            $data['identifier'] = $this->identifier;
        }

        if ($this->manufacturerReference !== null) {
            $data['manufacturer'] = ['reference' => $this->manufacturerReference];
        }

        return $data;
    }
}
