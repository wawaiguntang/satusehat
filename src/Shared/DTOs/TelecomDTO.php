<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

use Wawaiguntang\Satusehat\Shared\Enums\TelecomSystemEnum;
use Wawaiguntang\Satusehat\Shared\Enums\TelecomUseEnum;

/**
 * FHIR R4 - ContactPoint datatype (telecom)
 * @see https://www.hl7.org/fhir/datatypes.html#ContactPoint
 *
 * Digunakan oleh: Patient, Practitioner, Organization, dan resource FHIR lainnya.
 */
class TelecomDTO
{
    public function __construct(
        /** @var TelecomSystemEnum Jenis kontak: phone, email, dll */
        public readonly TelecomSystemEnum $system,

        /** @var string Nilai kontak (nomor HP, alamat email, URL, dll) */
        public readonly string $value,

        /** @var TelecomUseEnum Penggunaan kontak: home, mobile, work, dll */
        public readonly TelecomUseEnum $use,
    ) {}

    public function toArray(): array
    {
        return [
            'system' => $this->system->value,
            'value'  => $this->value,
            'use'    => $this->use->value,
        ];
    }
}
