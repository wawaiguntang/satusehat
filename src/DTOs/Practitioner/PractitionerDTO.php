<?php

namespace Wawaiguntang\Satusehat\DTOs\Practitioner;

use Wawaiguntang\Satusehat\Shared\DTOs\AddressDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\HumanNameDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\IdentifierDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\TelecomDTO;
use Wawaiguntang\Satusehat\Shared\Enums\GenderEnum;

/**
 * FHIR R4 - Practitioner Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Practitioner
 *
 * Digunakan untuk merepresentasikan tenaga kesehatan (dokter, perawat, bidan, dll.)
 * yang terdaftar di ekosistem SATUSEHAT.
 *
 * Resource Practitioner bersifat read-only dari SATUSEHAT — tidak ada endpoint POST/PATCH.
 * Data diambil via GET /Practitioner dengan parameter pencarian.
 *
 * Field yang tersedia dalam response:
 *  - identifier    : NIK tenaga kesehatan
 *  - name          : nama lengkap
 *  - gender        : jenis kelamin
 *  - birthDate     : tanggal lahir
 *  - address       : alamat domisili
 *  - telecom       : kontak (opsional)
 *  - qualification : kualifikasi/kompetensi (opsional)
 */
class PractitionerDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string ID unik Practitioner di SATUSEHAT (contoh: "10006926841") */
        public readonly string $id,

        /** @var IdentifierDTO[] Identifier tenaga kesehatan, minimal berisi NIK */
        public readonly array $identifier,

        /** @var HumanNameDTO[] Nama tenaga kesehatan, min 1, use 'official' */
        public readonly array $name,

        /** @var GenderEnum Jenis kelamin */
        public readonly GenderEnum $gender,

        /** @var string Tanggal lahir format Y-m-d */
        public readonly string $birthDate,

        /** @var AddressDTO[] Alamat domisili tenaga kesehatan */
        public readonly array $address,

        public readonly bool $active = true,

        /** @var TelecomDTO[]|null Kontak tenaga kesehatan (opsional) */
        public readonly ?array $telecom = null,

        /** @var PractitionerQualificationDTO[]|null Kualifikasi/kompetensi (opsional) */
        public readonly ?array $qualification = null,
    ) {
        $this->resourceType = 'Practitioner';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'id'           => $this->id,
            'active'       => $this->active,
            'identifier'   => array_map(fn($i) => $i->toArray(), $this->identifier),
            'name'         => array_map(fn($n) => $n->toArray(), $this->name),
            'gender'       => $this->gender->value,
            'birthDate'    => $this->birthDate,
            'address'      => array_map(fn($a) => $a->toArray(), $this->address),
        ];

        if ($this->telecom !== null) {
            $data['telecom'] = array_map(fn($t) => $t->toArray(), $this->telecom);
        }

        if ($this->qualification !== null) {
            $data['qualification'] = array_map(fn($q) => $q->toArray(), $this->qualification);
        }

        return $data;
    }
}
