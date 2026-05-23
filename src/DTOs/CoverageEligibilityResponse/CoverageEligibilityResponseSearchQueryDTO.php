<?php

namespace Wawaiguntang\Satusehat\DTOs\CoverageEligibilityResponse;

/**
 * Query parameter untuk GET /CoverageEligibilityResponse
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/CoverageEligibilityResponse
 */
class CoverageEligibilityResponseSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $patient = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->patient !== null) {
            $params['patient'] = $this->patient;
        }

        return $params;
    }
}
