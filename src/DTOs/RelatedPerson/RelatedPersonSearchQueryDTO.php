<?php

namespace Wawaiguntang\Satusehat\DTOs\RelatedPerson;

/**
 * Query parameter untuk GET /RelatedPerson
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/RelatedPerson
 *
 * Parameter yang didukung:
 *  - patient    → ID pasien
 *  - identifier → NIK (format: system|value)
 *                 Contoh: "https://fhir.kemkes.go.id/id/nik|367400001111222"
 */
class RelatedPersonSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $patient = null,

        /** @var string|null NIK (format: system|value) */
        public readonly ?string $identifier = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->patient !== null) {
            $params['patient'] = $this->patient;
        }

        if ($this->identifier !== null) {
            $params['identifier'] = $this->identifier;
        }

        return $params;
    }
}
