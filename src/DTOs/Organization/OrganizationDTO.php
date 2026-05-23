<?php

namespace Wawaiguntang\Satusehat\DTOs\Organization;

use Wawaiguntang\Satusehat\Shared\DTOs\AddressDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\TelecomDTO;

/**
 * FHIR R4 - Organization Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Organization
 *
 * Digunakan untuk merepresentasikan unit pelayanan / departemen rumah sakit
 * yang terdaftar di ekosistem SATUSEHAT.
 *
 * Operasi yang didukung:
 *  - POST   /Organization           → create (wajib: identifier, type, name)
 *  - GET    /Organization/:id       → by ID
 *  - GET    /Organization?name=     → search by name
 *  - GET    /Organization?partof=   → search by partOf
 *  - PUT    /Organization/:id       → full update (wajib: id + semua field)
 *  - PATCH  /Organization/:id       → partial update via JSON Patch (RFC 6902)
 *
 * Field identifier.system menggunakan pola:
 *  http://sys-ids.kemkes.go.id/organization/{Org_id}
 */
class OrganizationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string Nama organisasi/unit pelayanan */
        public readonly string $name,

        /**
         * @var array Identifier organisasi
         * Struktur: ['use' => string, 'system' => string, 'value' => string]
         * system: "http://sys-ids.kemkes.go.id/organization/{orgId}"
         */
        public readonly array $identifier,

        /** @var OrganizationTypeDTO[] Tipe organisasi, min 1 */
        public readonly array $type,

        public readonly bool $active = true,

        /** @var string|null ID unik Organization di SATUSEHAT (wajib untuk PUT) */
        public readonly ?string $id = null,

        /** @var TelecomDTO[]|null Kontak organisasi (opsional) */
        public readonly ?array $telecom = null,

        /** @var AddressDTO[]|null Alamat organisasi (opsional) */
        public readonly ?array $address = null,

        /** @var string|null Referensi organisasi induk, contoh: "Organization/10000004" */
        public readonly ?string $partOfReference = null,

        /** @var OrganizationContactDTO[]|null Kontak person organisasi (opsional) */
        public readonly ?array $contact = null,
    ) {
        $this->resourceType = 'Organization';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'active'       => $this->active,
            'identifier'   => $this->identifier,
            'type'         => array_map(fn($t) => $t->toArray(), $this->type),
            'name'         => $this->name,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->telecom !== null) {
            $data['telecom'] = array_map(fn($t) => $t->toArray(), $this->telecom);
        }

        if ($this->address !== null) {
            $data['address'] = array_map(fn($a) => $a->toArray(), $this->address);
        }

        if ($this->partOfReference !== null) {
            $data['partOf'] = ['reference' => $this->partOfReference];
        }

        if ($this->contact !== null) {
            $data['contact'] = array_map(fn($c) => $c->toArray(), $this->contact);
        }

        return $data;
    }
}
