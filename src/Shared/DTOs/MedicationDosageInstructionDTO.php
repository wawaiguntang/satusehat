<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

/**
 * FHIR R4 - dosageInstruction (Dosage datatype)
 * @see https://www.hl7.org/fhir/dosage.html
 *
 * Digunakan oleh: MedicationRequest, MedicationDispense.
 *
 * Route coding menggunakan ATC WHO: http://www.whocc.no/atc
 * DoseAndRate type: http://terminology.hl7.org/CodeSystem/dose-rate-type
 * Dose unit: http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm
 * Timing periodUnit: http://unitsofmeasure.org (d=day, h=hour, min=minute, wk=week, mo=month)
 */
class MedicationDosageInstructionDTO
{
    public function __construct(
        /** @var int Urutan instruksi (mulai dari 1) */
        public readonly int $sequence,

        /** @var string Teks instruksi dosis (contoh: "4 tablet per hari") */
        public readonly string $text,

        /** @var float Jumlah dosis per pemberian */
        public readonly float $doseValue,

        /** @var string Satuan dosis (contoh: "TAB") */
        public readonly string $doseUnit,

        /** @var int Frekuensi pemberian per periode */
        public readonly int $timingFrequency,

        /** @var int Nilai periode waktu */
        public readonly int $timingPeriod,

        /** @var string Satuan periode (d=hari, h=jam, wk=minggu, mo=bulan) */
        public readonly string $timingPeriodUnit,

        /** @var string|null Instruksi tambahan (contoh: "Diminum setiap hari") */
        public readonly ?string $additionalInstruction = null,

        /** @var string|null Instruksi untuk pasien */
        public readonly ?string $patientInstruction = null,

        /** @var string|null Kode rute pemberian (contoh: "O" = Oral) */
        public readonly ?string $routeCode = null,

        /** @var string|null Display rute pemberian (contoh: "Oral") */
        public readonly ?string $routeDisplay = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'sequence'      => $this->sequence,
            'text'          => $this->text,
            'doseAndRate'   => [
                [
                    'type'         => [
                        'coding' => [
                            [
                                'system'  => 'http://terminology.hl7.org/CodeSystem/dose-rate-type',
                                'code'    => 'ordered',
                                'display' => 'Ordered',
                            ],
                        ],
                    ],
                    'doseQuantity' => [
                        'value'  => $this->doseValue,
                        'unit'   => $this->doseUnit,
                        'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                        'code'   => $this->doseUnit,
                    ],
                ],
            ],
            'timing' => [
                'repeat' => [
                    'frequency'  => $this->timingFrequency,
                    'period'     => $this->timingPeriod,
                    'periodUnit' => $this->timingPeriodUnit,
                ],
            ],
        ];

        if ($this->additionalInstruction !== null) {
            $data['additionalInstruction'] = [['text' => $this->additionalInstruction]];
        }

        if ($this->patientInstruction !== null) {
            $data['patientInstruction'] = $this->patientInstruction;
        }

        if ($this->routeCode !== null) {
            $data['route'] = [
                'coding' => [
                    [
                        'system'  => 'http://www.whocc.no/atc',
                        'code'    => $this->routeCode,
                        'display' => $this->routeDisplay ?? $this->routeCode,
                    ],
                ],
            ];
        }

        return $data;
    }
}
