<?php

namespace Wawaiguntang\Satusehat\DTOs\AllergyIntolerance;

/**
 * Query parameter untuk GET /AllergyIntolerance
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/AllergyIntolerance
 *
 * Catatan: AllergyIntolerance menggunakan `patient` (bukan `subject`).
 */
class AllergyIntoleranceSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $patient = null,

        /** @var string|null UUID encounter */
        public readonly ?string $encounter = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->patient !== null) {
            $params['patient'] = $this->patient;
        }

        if ($this->encounter !== null) {
            $params['encounter'] = $this->encounter;
        }

        return $params;
    }
}
