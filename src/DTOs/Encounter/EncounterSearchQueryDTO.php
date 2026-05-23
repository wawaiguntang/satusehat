<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

/**
 * Query parameter untuk GET /Encounter
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Encounter
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - subject           → ID pasien (Patient ID / IHS Number)
 *  - date              → filter berdasarkan tanggal kunjungan
 *  - location          → ID Location
 *  - service-provider  → ID Organization
 *  - identifier        → system|value identifier kunjungan
 */
class EncounterSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien (contoh: "100000030009") */
        public readonly ?string $subject = null,

        /**
         * @var string|null Filter tanggal kunjungan
         * Format: "YYYY-MM-DD" atau dengan prefix operator (contoh: "ge2022-06-01")
         */
        public readonly ?string $date = null,

        /** @var string|null ID Location tempat kunjungan */
        public readonly ?string $location = null,

        /** @var string|null ID Organization penyelenggara */
        public readonly ?string $serviceProvider = null,

        /** @var string|null Nilai identifier kunjungan */
        public readonly ?string $identifierValue = null,

        /**
         * @var string|null System identifier kunjungan
         * Contoh: "http://sys-ids.kemkes.go.id/encounter/{orgId}"
         */
        public readonly ?string $identifierSystem = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        if ($this->date !== null) {
            $params['date'] = $this->date;
        }

        if ($this->location !== null) {
            $params['location'] = $this->location;
        }

        if ($this->serviceProvider !== null) {
            $params['service-provider'] = $this->serviceProvider;
        }

        if ($this->identifierValue !== null) {
            $params['identifier'] = $this->identifierSystem !== null
                ? $this->identifierSystem . '|' . $this->identifierValue
                : $this->identifierValue;
        }

        return $params;
    }
}
