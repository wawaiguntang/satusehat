<?php

namespace Wawaiguntang\Satusehat\DTOs\Medication;

/**
 * Query parameter untuk GET /Medication
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Medication
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - code        → KFA code obat (format: system|code)
 *  - identifier  → identifier obat
 */
class MedicationSearchQueryDTO
{
    public function __construct(
        /** @var string|null Kode KFA obat */
        public readonly ?string $code = null,

        /** @var string|null Nilai identifier */
        public readonly ?string $identifierValue = null,

        /** @var string|null System identifier */
        public readonly ?string $identifierSystem = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->code !== null) {
            $params['code'] = 'http://sys-ids.kemkes.go.id/kfa|' . $this->code;
        }

        if ($this->identifierValue !== null) {
            $params['identifier'] = $this->identifierSystem !== null
                ? $this->identifierSystem . '|' . $this->identifierValue
                : $this->identifierValue;
        }

        return $params;
    }
}
