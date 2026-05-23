<?php

namespace Wawaiguntang\Satusehat\DTOs\Specimen;

/**
 * Query parameter untuk GET /Specimen
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Specimen
 *
 * Parameter yang didukung:
 *  - subject    → ID pasien
 *  - collected  → tanggal pengambilan (YYYY-MM-DD)
 *  - identifier → identifier spesimen (format: system|value)
 *  - request    → UUID ServiceRequest
 */
class SpecimenSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $subject = null,

        /** @var string|null Tanggal pengambilan (YYYY-MM-DD) */
        public readonly ?string $collected = null,

        /** @var string|null Identifier spesimen (format: system|value, contoh: "http://sys-ids.kemkes.go.id/specimen-acsn|1000000004") */
        public readonly ?string $identifier = null,

        /** @var string|null UUID ServiceRequest */
        public readonly ?string $request = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        if ($this->collected !== null) {
            $params['collected'] = $this->collected;
        }

        if ($this->identifier !== null) {
            $params['identifier'] = $this->identifier;
        }

        if ($this->request !== null) {
            $params['request'] = $this->request;
        }

        return $params;
    }
}
