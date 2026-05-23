<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

/**
 * FHIR R4 - Encounter.location
 * @see https://www.hl7.org/fhir/encounter-definitions.html#Encounter.location
 */
class EncounterLocationDTO
{
    public function __construct(
        /** @var string Referensi Location (contoh: "Location/b017aa54-f1df-4ec2-9d84-8823815d7228") */
        public readonly string $locationReference,

        /** @var string|null Nama tampilan lokasi */
        public readonly ?string $locationDisplay = null,
    ) {}

    public function toArray(): array
    {
        $location = ['reference' => $this->locationReference];
        if ($this->locationDisplay !== null) {
            $location['display'] = $this->locationDisplay;
        }

        return [
            'location' => $location,
        ];
    }
}
