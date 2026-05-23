<?php

namespace Wawaiguntang\Satusehat\DTOs\Organization;

/**
 * Query parameter untuk GET /Organization
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Organization
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - name              → cari berdasarkan nama organisasi
 *  - partof            → cari unit yang berada di bawah organisasi induk
 */
class OrganizationSearchQueryDTO
{
    public function __construct(
        /** @var string|null Nama organisasi (pencarian partial) */
        public readonly ?string $name = null,

        /** @var string|null ID organisasi induk (contoh: "10000004") */
        public readonly ?string $partof = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->name !== null) {
            $params['name'] = $this->name;
        }

        if ($this->partof !== null) {
            $params['partof'] = $this->partof;
        }

        return $params;
    }
}
