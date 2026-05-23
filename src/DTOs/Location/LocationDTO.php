<?php

namespace Wawaiguntang\Satusehat\DTOs\Location;

use Wawaiguntang\Satusehat\Enums\Location\LocationModeEnum;
use Wawaiguntang\Satusehat\Enums\Location\LocationPhysicalTypeEnum;
use Wawaiguntang\Satusehat\Enums\Location\LocationStatusEnum;
use Wawaiguntang\Satusehat\Shared\DTOs\AddressDTO;
use Wawaiguntang\Satusehat\Shared\DTOs\TelecomDTO;

/**
 * FHIR R4 - Location Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Location
 *
 * Merepresentasikan lokasi fisik tempat pelayanan kesehatan dilakukan,
 * misal: ruang periksa, bangsal, gedung, dsb.
 *
 * Operasi yang didukung:
 *  - POST  /Location              → create (wajib: identifier, status, name, mode)
 *  - GET   /Location/:id          → by ID
 *  - GET   /Location?identifier=  → search by identifier
 *  - GET   /Location?name=        → search by name
 *  - GET   /Location?organization= → search by managing organization
 *  - PUT   /Location/:id          → full update (wajib: id)
 *  - PATCH /Location/:id          → partial update via JSON Patch (RFC 6902)
 *
 * Field identifier.system menggunakan pola:
 *  http://sys-ids.kemkes.go.id/location/{Org_id}
 *
 * Catatan: field address adalah object tunggal (bukan array) berbeda dengan Patient/Practitioner.
 */
class LocationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string Nama lokasi (contoh: "Ruang 1A IRJT") */
        public readonly string $name,

        /** @var LocationStatusEnum Status operasional lokasi */
        public readonly LocationStatusEnum $status,

        /** @var LocationModeEnum Mode lokasi, default 'instance' untuk lokasi spesifik */
        public readonly LocationModeEnum $mode,

        /**
         * @var array Identifier lokasi
         * Struktur: ['system' => string, 'value' => string]
         * system: "http://sys-ids.kemkes.go.id/location/{orgId}"
         */
        public readonly array $identifier,

        /** @var string|null ID unik Location di SATUSEHAT (wajib untuk PUT) */
        public readonly ?string $id = null,

        /** @var string|null Deskripsi detail lokasi (opsional) */
        public readonly ?string $description = null,

        /** @var TelecomDTO[]|null Kontak lokasi (opsional) */
        public readonly ?array $telecom = null,

        /** @var AddressDTO|null Alamat lokasi — object tunggal, bukan array (opsional) */
        public readonly ?AddressDTO $address = null,

        /**
         * @var LocationPhysicalTypeEnum|null Tipe fisik lokasi
         * Contoh: ro (Room), wa (Ward), bu (Building), dll.
         */
        public readonly ?LocationPhysicalTypeEnum $physicalType = null,

        /** @var string|null Display teks untuk physicalType (contoh: "Room") */
        public readonly ?string $physicalTypeDisplay = null,

        /** @var string|null Referensi organisasi pengelola, contoh: "Organization/10000004" */
        public readonly ?string $managingOrganizationReference = null,
    ) {
        $this->resourceType = 'Location';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => $this->identifier,
            'status'       => $this->status->value,
            'name'         => $this->name,
            'mode'         => $this->mode->value,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->telecom !== null) {
            $data['telecom'] = array_map(fn($t) => $t->toArray(), $this->telecom);
        }

        if ($this->address !== null) {
            $data['address'] = $this->address->toArray();
        }

        if ($this->physicalType !== null) {
            $data['physicalType'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/location-physical-type',
                        'code'    => $this->physicalType->value,
                        'display' => $this->physicalTypeDisplay ?? $this->physicalType->value,
                    ],
                ],
            ];
        }

        if ($this->managingOrganizationReference !== null) {
            $data['managingOrganization'] = ['reference' => $this->managingOrganizationReference];
        }

        return $data;
    }
}
