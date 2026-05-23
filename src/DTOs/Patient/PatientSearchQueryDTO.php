<?php

namespace Wawaiguntang\Satusehat\DTOs\Patient;

use Wawaiguntang\Satusehat\Shared\Enums\GenderEnum;
use Wawaiguntang\Satusehat\Shared\Enums\IdentifierSystemEnum;

/**
 * Query parameter untuk GET /Patient
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Patient
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - name + birthdate + gender
 *  - name + birthdate + identifier (NIK)
 *  - name + identifier (NIK)
 *  - identifier (NIK) saja
 *  - identifier (NIK Ibu) + birthdate  → untuk cari bayi baru lahir
 */
class PatientSearchQueryDTO
{
    public function __construct(
        public readonly ?string $name = null,

        /** @var string|null Tanggal lahir format Y-m-d */
        public readonly ?string $birthdate = null,

        public readonly ?GenderEnum $gender = null,

        /** @var string|null Nilai identifier (nomor NIK atau NIK Ibu) */
        public readonly ?string $identifierValue = null,

        /** @var IdentifierSystemEnum|null Sistem identifier yang digunakan */
        public readonly ?IdentifierSystemEnum $identifierSystem = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->name !== null) {
            $params['name'] = $this->name;
        }

        if ($this->birthdate !== null) {
            $params['birthdate'] = $this->birthdate;
        }

        if ($this->gender !== null) {
            $params['gender'] = $this->gender->value;
        }

        if ($this->identifierValue !== null && $this->identifierSystem !== null) {
            $params['identifier'] = $this->identifierSystem->value . '|' . $this->identifierValue;
        }

        return $params;
    }
}
