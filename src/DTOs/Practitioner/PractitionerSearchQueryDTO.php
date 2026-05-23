<?php

namespace Wawaiguntang\Satusehat\DTOs\Practitioner;

use Wawaiguntang\Satusehat\Shared\Enums\GenderEnum;
use Wawaiguntang\Satusehat\Shared\Enums\IdentifierSystemEnum;

/**
 * Query parameter untuk GET /Practitioner
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Practitioner
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - name + identifier (NIK)       → pencarian paling akurat
 *  - identifier (NIK) saja         → berdasarkan NIK
 *  - name + gender + birthdate     → tanpa NIK
 */
class PractitionerSearchQueryDTO
{
    public function __construct(
        public readonly ?string $name = null,

        /** @var string|null Nilai NIK tenaga kesehatan (16 digit) */
        public readonly ?string $identifierValue = null,

        /** @var IdentifierSystemEnum|null Sistem identifier, biasanya IdentifierSystemEnum::NIK */
        public readonly ?IdentifierSystemEnum $identifierSystem = null,

        public readonly ?GenderEnum $gender = null,

        /** @var string|null Tanggal lahir format Y-m-d */
        public readonly ?string $birthdate = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->name !== null) {
            $params['name'] = $this->name;
        }

        if ($this->identifierValue !== null && $this->identifierSystem !== null) {
            $params['identifier'] = $this->identifierSystem->value . '|' . $this->identifierValue;
        }

        if ($this->gender !== null) {
            $params['gender'] = $this->gender->value;
        }

        if ($this->birthdate !== null) {
            $params['birthdate'] = $this->birthdate;
        }

        return $params;
    }
}
