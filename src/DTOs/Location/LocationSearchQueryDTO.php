<?php

namespace Wawaiguntang\Satusehat\DTOs\Location;

/**
 * Query parameter untuk GET /Location
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Location
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - identifier  → system|value (contoh: "http://sys-ids.kemkes.go.id/location/1000001|G-2-R-1A")
 *  - name        → pencarian partial nama lokasi
 *  - organization → ID atau referensi organisasi pengelola
 */
class LocationSearchQueryDTO
{
    public function __construct(
        /** @var string|null Nama lokasi (pencarian partial) */
        public readonly ?string $name = null,

        /**
         * @var string|null Nilai identifier lokasi
         * Kombinasikan dengan $identifierSystem untuk format system|value
         */
        public readonly ?string $identifierValue = null,

        /**
         * @var string|null System identifier
         * Contoh: "http://sys-ids.kemkes.go.id/location/{orgId}"
         */
        public readonly ?string $identifierSystem = null,

        /** @var string|null ID atau referensi Organization pengelola (contoh: "10000004") */
        public readonly ?string $organization = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->name !== null) {
            $params['name'] = $this->name;
        }

        if ($this->identifierValue !== null) {
            $params['identifier'] = $this->identifierSystem !== null
                ? $this->identifierSystem . '|' . $this->identifierValue
                : $this->identifierValue;
        }

        if ($this->organization !== null) {
            $params['organization'] = $this->organization;
        }

        return $params;
    }
}
