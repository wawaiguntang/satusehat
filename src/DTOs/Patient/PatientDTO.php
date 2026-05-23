<?php

namespace Wawaiguntang\Satusehat\DTOs\Patient;

use Wawaiguntang\Satusehat\Shared\DTOs\AddressDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\HumanNameDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\IdentifierDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\TelecomDTO;
use Wawaiguntang\Satusehat\Shared\Enums\GenderEnum;

/**
 * FHIR R4 - Patient Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Patient
 *
 * Field mandatory untuk POST Patient (by NIK):
 *  - resourceType  : harus "Patient"
 *  - meta.profile  : ["https://fhir.kemkes.go.id/r4/StructureDefinition/Patient"]
 *  - identifier    : min 1 (NIK atau NIK Ibu)
 *  - name          : min 1, use "official"
 *  - gender        : wajib sesuai data Dukcapil
 *  - birthDate     : wajib sesuai data Dukcapil
 *  - address       : wajib, termasuk kode wilayah administratif
 *
 * Untuk bayi baru lahir (by NIK Ibu):
 *  - identifier.system = IdentifierSystemEnum::NIKIbu
 *  - birthDate tidak boleh lebih dari 60 hari dari tanggal submit
 */
class PatientDTO
{
    public readonly string $resourceType;
    public readonly array $metaProfile;

    public function __construct(
        /** @var IdentifierDTO[] Min 1, gunakan NIK atau NIK Ibu */
        public readonly array $identifier,

        /** @var HumanNameDTO[] Min 1, use 'official' */
        public readonly array $name,

        /** @var GenderEnum Jenis kelamin, harus sesuai data Dukcapil */
        public readonly GenderEnum $gender,

        /** @var string Tanggal lahir format Y-m-d (contoh: 1990-01-15) */
        public readonly string $birthDate,

        /** @var AddressDTO[] Minimal 1 alamat wajib disertakan */
        public readonly array $address,

        public readonly bool $active = true,
        public readonly bool $deceasedBoolean = false,
        public readonly int $multipleBirthInteger = 0,

        /** @var TelecomDTO[]|null Kontak pasien (opsional) */
        public readonly ?array $telecom = null,
    ) {
        $this->resourceType = 'Patient';
        $this->metaProfile  = ['https://fhir.kemkes.go.id/r4/StructureDefinition/Patient'];
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'         => $this->resourceType,
            'meta'                 => ['profile' => $this->metaProfile],
            'identifier'           => array_map(fn($i) => $i->toArray(), $this->identifier),
            'active'               => $this->active,
            'name'                 => array_map(fn($n) => $n->toArray(), $this->name),
            'gender'               => $this->gender->value,
            'birthDate'            => $this->birthDate,
            'deceasedBoolean'      => $this->deceasedBoolean,
            'multipleBirthInteger' => $this->multipleBirthInteger,
            'address'              => array_map(fn($a) => $a->toArray(), $this->address),
        ];

        if ($this->telecom !== null) {
            $data['telecom'] = array_map(fn($t) => $t->toArray(), $this->telecom);
        }

        return $data;
    }
}
