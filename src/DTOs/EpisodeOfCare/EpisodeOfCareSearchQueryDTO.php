<?php

namespace Wawaiguntang\Satusehat\DTOs\EpisodeOfCare;

/**
 * Query parameter untuk GET /EpisodeOfCare
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/EpisodeOfCare
 *
 * Catatan: EpisodeOfCare menggunakan `patient` (bukan `subject`).
 */
class EpisodeOfCareSearchQueryDTO
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
