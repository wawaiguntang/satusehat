<?php

namespace Wawaiguntang\Satusehat\DTOs\Organization;

use Wawaiguntang\Satusehat\Shared\DTOs\TelecomDTO;

/**
 * FHIR R4 - Organization.contact
 * @see https://www.hl7.org/fhir/organization-definitions.html#Organization.contact
 *
 * Mewakili kontak person untuk suatu organisasi.
 */
class OrganizationContactDTO
{
    public function __construct(
        /** @var string Nama kontak person */
        public readonly string $nameText,

        /** @var TelecomDTO[]|null Daftar kontak person (opsional) */
        public readonly ?array $telecom = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'name' => [
                'text' => $this->nameText,
            ],
        ];

        if ($this->telecom !== null) {
            $data['telecom'] = array_map(fn($t) => $t->toArray(), $this->telecom);
        }

        return $data;
    }
}
