<?php

namespace Wawaiguntang\Satusehat\DTOs\CoverageEligibilityRequest;

/**
 * Query parameter untuk GET /CoverageEligibilityRequest
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/CoverageEligibilityRequest
 *
 * Resource ini bersifat read-only dari faskes — dibuat otomatis oleh sistem SATUSEHAT.
 *
 * Parameter yang didukung:
 *  - identifier → nomor asuransi (format: system|value)
 *                 Contoh: "https://sys-ids.kemkes.go.id/insurance-number/{Org_id}|{nomor}"
 *  - patient    → ID pasien
 *
 * Operasi khusus: GET /:id/$everything → mendapatkan semua resource terkait
 */
class CoverageEligibilityRequestSearchQueryDTO
{
    public function __construct(
        /** @var string|null Nomor asuransi (format: system|value) */
        public readonly ?string $identifier = null,

        /** @var string|null ID pasien */
        public readonly ?string $patient = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->identifier !== null) {
            $params['identifier'] = $this->identifier;
        }

        if ($this->patient !== null) {
            $params['patient'] = $this->patient;
        }

        return $params;
    }
}
