<?php

namespace Wawaiguntang\Satusehat\DTOs\Organization;

use Wawaiguntang\Satusehat\Enums\Organization\OrganizationTypeEnum;

/**
 * FHIR R4 - Organization.type (CodeableConcept)
 * @see https://www.hl7.org/fhir/organization-definitions.html#Organization.type
 *
 * Standard: http://terminology.hl7.org/CodeSystem/organization-type
 */
class OrganizationTypeDTO
{
    public function __construct(
        /** @var OrganizationTypeEnum Kode tipe organisasi */
        public readonly OrganizationTypeEnum $code,

        /** @var string Nama tipe organisasi (contoh: "Hospital Department") */
        public readonly string $display,
    ) {}

    public function toArray(): array
    {
        return [
            'coding' => [
                [
                    'system'  => 'http://terminology.hl7.org/CodeSystem/organization-type',
                    'code'    => $this->code->value,
                    'display' => $this->display,
                ],
            ],
        ];
    }
}
