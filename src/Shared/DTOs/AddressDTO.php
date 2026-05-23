<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

use Wawaiguntang\Satusehat\Shared\Enums\AddressUseEnum;

/**
 * FHIR R4 - Address datatype
 * @see https://www.hl7.org/fhir/datatypes.html#Address
 *
 * Digunakan oleh: Patient, Practitioner, Organization, dan resource FHIR lainnya.
 * Kode wilayah (province, city, district, village, rt, rw) harus sesuai data Kemendagri.
 */
class AddressDTO
{
    public function __construct(
        /** @var AddressUseEnum Penggunaan alamat: 'home', 'work', 'temp', dll */
        public readonly AddressUseEnum $use,

        /** @var string[] Baris alamat (jalan, gedung, dll) */
        public readonly array $line,

        /** @var string Nama kota/kabupaten */
        public readonly string $city,

        /** @var string Kode pos */
        public readonly string $postalCode,

        /** @var string Kode negara, selalu 'ID' untuk Indonesia */
        public readonly string $country,

        /** @var AddressExtensionDTO Kode wilayah administratif (wajib untuk POST resource) */
        public readonly AddressExtensionDTO $administrativeCode,

        /**
         * @var string|null Tipe alamat
         * Standard: http://hl7.org/fhir/address-type
         * Nilai: 'postal' | 'physical' | 'both'
         * Digunakan oleh Organization, opsional untuk Patient/Practitioner
         */
        public readonly ?string $type = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'use'        => $this->use->value,
            'line'       => $this->line,
            'city'       => $this->city,
            'postalCode' => $this->postalCode,
            'country'    => $this->country,
            'extension'  => [$this->administrativeCode->toArray()],
        ];

        if ($this->type !== null) {
            $data['type'] = $this->type;
        }

        return $data;
    }
}
