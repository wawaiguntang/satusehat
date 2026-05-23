<?php

namespace Wawaiguntang\Satusehat\DTOs\Coverage;

/**
 * Query parameter untuk GET /Coverage
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Coverage
 *
 * Parameter yang didukung:
 *  - patient    → ID pasien
 *  - identifier → nomor kepesertaan (format: system|value)
 *                 Contoh: "https://sys-ids.kemkes.go.id/insurance-subscriber/100071505|0001105689835"
 */
class CoverageSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $patient = null,

        /** @var string|null Nomor kepesertaan (format: system|value) */
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
