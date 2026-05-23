<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

use Wawaiguntang\Satusehat\Shared\Enums\IdentifierSystemEnum;
use Wawaiguntang\Satusehat\Shared\Enums\IdentifierUseEnum;

/**
 * FHIR R4 - Identifier datatype
 * @see https://www.hl7.org/fhir/datatypes.html#Identifier
 *
 * Digunakan oleh: Patient, Practitioner, Organization, dan resource FHIR lainnya.
 */
class IdentifierDTO
{
    public function __construct(
        /** @var IdentifierUseEnum Penggunaan identifier, biasanya 'official' */
        public readonly IdentifierUseEnum $use,

        /** @var IdentifierSystemEnum Sistem identifikasi (NIK, NIK Ibu, IHS Number) */
        public readonly IdentifierSystemEnum $system,

        /** @var string Nilai identifier (misal: nomor NIK 16 digit) */
        public readonly string $value,
    ) {}

    public function toArray(): array
    {
        return [
            'use'    => $this->use->value,
            'system' => $this->system->value,
            'value'  => $this->value,
        ];
    }
}
