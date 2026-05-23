<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

/**
 * FHIR R4 - address.extension (administrativeCode)
 * Extension kode wilayah administratif Indonesia (Kemendagri)
 * @see https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode
 *
 * Digunakan oleh: Patient, Practitioner, Organization, dan resource FHIR lainnya.
 *
 * Semua kode mengacu pada data wilayah Kemendagri:
 * - province  : 2 digit
 * - city      : 4 digit
 * - district  : 6 digit
 * - village   : 10 digit
 * - rt        : nomor RT
 * - rw        : nomor RW
 */
class AddressExtensionDTO
{
    public function __construct(
        public readonly string $province,
        public readonly string $city,
        public readonly string $district,
        public readonly string $village,
        public readonly string $rt,
        public readonly string $rw,
    ) {}

    public function toArray(): array
    {
        return [
            'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
            'extension' => [
                ['url' => 'province', 'valueCode' => $this->province],
                ['url' => 'city',     'valueCode' => $this->city],
                ['url' => 'district', 'valueCode' => $this->district],
                ['url' => 'village',  'valueCode' => $this->village],
                ['url' => 'rt',       'valueCode' => $this->rt],
                ['url' => 'rw',       'valueCode' => $this->rw],
            ],
        ];
    }
}
