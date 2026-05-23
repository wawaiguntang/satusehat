<?php

namespace Wawaiguntang\Satusehat\DTOs\MedicationRequest;

/**
 * Query parameter untuk GET /MedicationRequest
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/MedicationRequest
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - subject   → ID pasien
 *  - encounter → UUID encounter
 */
class MedicationRequestSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $subject = null,

        /** @var string|null UUID encounter */
        public readonly ?string $encounter = null,
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

        return $params;
    }
}
