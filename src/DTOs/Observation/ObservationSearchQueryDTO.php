<?php

namespace Wawaiguntang\Satusehat\DTOs\Observation;

/**
 * Query parameter untuk GET /Observation
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Observation
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - subject   → ID pasien
 *  - encounter → UUID encounter
 *  - code      → kode LOINC (format: system|code)
 */
class ObservationSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $subject = null,

        /** @var string|null UUID encounter */
        public readonly ?string $encounter = null,

        /** @var string|null Kode LOINC (contoh: "8867-4" untuk heart rate) */
        public readonly ?string $loincCode = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        if ($this->encounter !== null) {
            $params['encounter'] = $this->encounter;
        }

        if ($this->loincCode !== null) {
            $params['code'] = 'http://loinc.org|' . $this->loincCode;
        }

        return $params;
    }
}
