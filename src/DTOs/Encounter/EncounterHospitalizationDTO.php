<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

use Wawaiguntang\Satusehat\Enums\Encounter\DischargeDispositionEnum;

/**
 * FHIR R4 - Encounter.hospitalization
 * @see https://www.hl7.org/fhir/encounter-definitions.html#Encounter.hospitalization
 *
 * Informasi kepulangan/discharge pasien.
 * Diisi pada saat status Encounter menjadi 'finished'.
 */
class EncounterHospitalizationDTO
{
    public function __construct(
        /** @var DischargeDispositionEnum Kode disposisi kepulangan */
        public readonly DischargeDispositionEnum $dischargeDisposition,

        /** @var string Display teks untuk kode disposisi */
        public readonly string $dischargeDispositionDisplay,

        /** @var string|null Catatan tambahan kepulangan (contoh: "Rujukan ke RSUP Fatmawati") */
        public readonly ?string $text = null,
    ) {}

    public function toArray(): array
    {
        $coding = [
            'coding' => [
                [
                    'system'  => 'http://terminology.hl7.org/CodeSystem/discharge-disposition',
                    'code'    => $this->dischargeDisposition->value,
                    'display' => $this->dischargeDispositionDisplay,
                ],
            ],
        ];

        if ($this->text !== null) {
            $coding['text'] = $this->text;
        }

        return [
            'dischargeDisposition' => $coding,
        ];
    }
}
