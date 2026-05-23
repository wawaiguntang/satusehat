<?php

namespace Wawaiguntang\Satusehat\DTOs\MedicationRequest;

/**
 * FHIR R4 - MedicationRequest.dispenseRequest
 * @see https://www.hl7.org/fhir/medicationrequest-definitions.html#MedicationRequest.dispenseRequest
 *
 * Informasi tentang dispensing/penyerahan obat yang diresepkan.
 * Satuan menggunakan UCUM: http://unitsofmeasure.org
 * Satuan sediaan: http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm
 */
class MedicationDispenseRequestDTO
{
    public function __construct(
        /** @var float Jumlah obat yang diresepkan */
        public readonly float $quantityValue,

        /** @var string Satuan jumlah (contoh: "TAB") */
        public readonly string $quantityCode,

        /** @var int Durasi suplai dalam hari */
        public readonly int $expectedSupplyDurationDays,

        /** @var int Jumlah pengulangan yang diizinkan (0 = tidak ada) */
        public readonly int $numberOfRepeatsAllowed = 0,

        /** @var string|null Referensi Organization apoteker */
        public readonly ?string $performerReference = null,

        /** @var int|null Interval dispensing dalam hari */
        public readonly ?int $dispenseIntervalDays = null,

        /** @var string|null Tanggal mulai masa berlaku resep (YYYY-MM-DD) */
        public readonly ?string $validityStart = null,

        /** @var string|null Tanggal akhir masa berlaku resep (YYYY-MM-DD) */
        public readonly ?string $validityEnd = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'numberOfRepeatsAllowed'   => $this->numberOfRepeatsAllowed,
            'quantity'                 => [
                'value'  => $this->quantityValue,
                'unit'   => $this->quantityCode,
                'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                'code'   => $this->quantityCode,
            ],
            'expectedSupplyDuration' => [
                'value'  => $this->expectedSupplyDurationDays,
                'unit'   => 'days',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'd',
            ],
        ];

        if ($this->dispenseIntervalDays !== null) {
            $data['dispenseInterval'] = [
                'value'  => $this->dispenseIntervalDays,
                'unit'   => 'days',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'd',
            ];
        }

        if ($this->validityStart !== null || $this->validityEnd !== null) {
            $validity = [];
            if ($this->validityStart !== null) {
                $validity['start'] = $this->validityStart;
            }
            if ($this->validityEnd !== null) {
                $validity['end'] = $this->validityEnd;
            }
            $data['validityPeriod'] = $validity;
        }

        if ($this->performerReference !== null) {
            $data['performer'] = ['reference' => $this->performerReference];
        }

        return $data;
    }
}
