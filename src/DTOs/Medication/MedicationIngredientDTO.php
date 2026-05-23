<?php

namespace Wawaiguntang\Satusehat\DTOs\Medication;

/**
 * FHIR R4 - Medication.ingredient
 * @see https://www.hl7.org/fhir/medication-definitions.html#Medication.ingredient
 *
 * Komponen/zat aktif dalam suatu sediaan obat.
 * Kode bahan menggunakan KFA: http://sys-ids.kemkes.go.id/kfa
 * Satuan menggunakan UCUM: http://unitsofmeasure.org
 * Satuan denominasi: http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm
 */
class MedicationIngredientDTO
{
    public function __construct(
        /** @var string Kode KFA bahan aktif */
        public readonly string $kfaCode,

        /** @var string Nama bahan aktif */
        public readonly string $kfaDisplay,

        /** @var float Nilai kekuatan bahan (numerator) */
        public readonly float $strengthNumeratorValue,

        /** @var string Satuan kekuatan bahan (contoh: "mg") */
        public readonly string $strengthNumeratorUnit,

        /** @var float Nilai denominator (biasanya 1) */
        public readonly float $strengthDenominatorValue,

        /** @var string Kode satuan sediaan denominator (contoh: "TAB") */
        public readonly string $strengthDenominatorCode,

        /** @var bool Apakah bahan aktif */
        public readonly bool $isActive = true,
    ) {}

    public function toArray(): array
    {
        return [
            'itemCodeableConcept' => [
                'coding' => [
                    [
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => $this->kfaCode,
                        'display' => $this->kfaDisplay,
                    ],
                ],
            ],
            'isActive' => $this->isActive,
            'strength' => [
                'numerator' => [
                    'value'  => $this->strengthNumeratorValue,
                    'system' => 'http://unitsofmeasure.org',
                    'code'   => $this->strengthNumeratorUnit,
                ],
                'denominator' => [
                    'value'  => $this->strengthDenominatorValue,
                    'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                    'code'   => $this->strengthDenominatorCode,
                ],
            ],
        ];
    }
}
