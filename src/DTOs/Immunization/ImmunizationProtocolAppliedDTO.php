<?php

namespace Wawaiguntang\Satusehat\DTOs\Immunization;

/**
 * FHIR R4 - Immunization.protocolApplied
 * @see https://www.hl7.org/fhir/immunization-definitions.html#Immunization.protocolApplied
 *
 * Informasi protokol/jadwal imunisasi yang diterapkan.
 */
class ImmunizationProtocolAppliedDTO
{
    public function __construct(
        /** @var string Nama seri imunisasi (contoh: "Imunisasi Rutin") */
        public readonly string $series,

        /** @var int Nomor dosis dalam seri */
        public readonly int $doseNumber,

        /** @var int|null Total dosis dalam seri */
        public readonly ?int $seriesDoses = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'series'            => $this->series,
            'doseNumberPositiveInt' => $this->doseNumber,
        ];

        if ($this->seriesDoses !== null) {
            $data['seriesDosesPositiveInt'] = $this->seriesDoses;
        }

        return $data;
    }
}
