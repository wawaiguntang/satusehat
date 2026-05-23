<?php

namespace Wawaiguntang\Satusehat\DTOs\ClaimResponse;

/**
 * Query parameter untuk GET /ClaimResponse
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/ClaimResponse
 */
class ClaimResponseSearchQueryDTO
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
