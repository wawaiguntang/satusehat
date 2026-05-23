<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

use Wawaiguntang\Satusehat\Shared\Enums\NameUseEnum;

/**
 * FHIR R4 - HumanName datatype
 * @see https://www.hl7.org/fhir/datatypes.html#HumanName
 *
 * Digunakan oleh: Patient, Practitioner, dan resource FHIR lainnya.
 */
class HumanNameDTO
{
    public function __construct(
        /** @var NameUseEnum Penggunaan nama, biasanya 'official' */
        public readonly NameUseEnum $use,

        /** @var string Nama lengkap dalam bentuk teks */
        public readonly string $text,
    ) {}

    public function toArray(): array
    {
        return [
            'use'  => $this->use->value,
            'text' => $this->text,
        ];
    }
}
