<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

use Wawaiguntang\Satusehat\Enums\Encounter\ParticipantTypeEnum;

/**
 * FHIR R4 - Encounter.participant
 * @see https://www.hl7.org/fhir/encounter-definitions.html#Encounter.participant
 */
class EncounterParticipantDTO
{
    public function __construct(
        /** @var ParticipantTypeEnum Peran peserta dalam kunjungan */
        public readonly ParticipantTypeEnum $type,

        /** @var string Display teks untuk tipe peserta (contoh: "attender") */
        public readonly string $typeDisplay,

        /** @var string Referensi Practitioner (contoh: "Practitioner/N10000001") */
        public readonly string $individualReference,

        /** @var string|null Nama tampilan Practitioner */
        public readonly ?string $individualDisplay = null,
    ) {}

    public function toArray(): array
    {
        $individual = ['reference' => $this->individualReference];
        if ($this->individualDisplay !== null) {
            $individual['display'] = $this->individualDisplay;
        }

        return [
            'type' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                            'code'    => $this->type->value,
                            'display' => $this->typeDisplay,
                        ],
                    ],
                ],
            ],
            'individual' => $individual,
        ];
    }
}
