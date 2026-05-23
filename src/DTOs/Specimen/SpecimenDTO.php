<?php

namespace Wawaiguntang\Satusehat\DTOs\Specimen;

use Wawaiguntang\Satusehat\Enums\Specimen\SpecimenStatusEnum;

/**
 * FHIR R4 - Specimen Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Specimen
 *
 * Merepresentasikan sampel/spesimen yang diambil dari pasien untuk pemeriksaan.
 *
 * Operasi yang didukung:
 *  - POST  /Specimen                   → create
 *  - GET   /Specimen/:id               → by ID
 *  - PUT   /Specimen/:id               → update
 *  - GET   /Specimen?subject=          → search by patient ID
 *  - GET   /Specimen?collected=        → search by tanggal pengambilan
 *  - GET   /Specimen?identifier=       → search by identifier (sistem|nilai)
 *  - GET   /Specimen?request=          → search by ServiceRequest ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/specimen/{Org_id}"
 * Field identifier ACSN: "http://sys-ids.kemkes.go.id/specimen-acsn"
 * Kode type menggunakan SNOMED CT: http://snomed.info/sct
 * Extension TransportedTime: https://fhir.kemkes.go.id/r4/StructureDefinition/TransportedTime
 */
class SpecimenDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var SpecimenStatusEnum Status spesimen */
        public readonly SpecimenStatusEnum $status,

        /** @var string Kode SNOMED CT jenis spesimen */
        public readonly string $typeCode,

        /** @var string Display jenis spesimen */
        public readonly string $typeDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var SpecimenCollectionDTO Informasi pengambilan spesimen */
        public readonly SpecimenCollectionDTO $collection,

        /** @var string Datetime diterima di lab (ISO 8601 + timezone) */
        public readonly string $receivedTime,

        /**
         * @var array Identifier spesimen
         * Struktur: [['system' => string, 'value' => string, 'assigner' => ['reference' => string]|null], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik Specimen di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string[]|null Referensi ServiceRequest */
        public readonly ?array $requestReferences = null,

        /** @var string|null Datetime transportasi spesimen (ISO 8601) — SATUSEHAT extension */
        public readonly ?string $transportedTime = null,
    ) {
        $this->resourceType = 'Specimen';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $data = [
            'resourceType' => $this->resourceType,
            'identifier'   => $this->identifier,
            'status'       => $this->status->value,
            'type'         => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'subject'      => $subject,
            'collection'   => $this->collection->toArray(),
            'receivedTime' => $this->receivedTime,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->requestReferences !== null) {
            $data['request'] = array_map(fn($r) => ['reference' => $r], $this->requestReferences);
        }

        if ($this->transportedTime !== null) {
            $data['extension'] = [
                [
                    'url'           => 'https://fhir.kemkes.go.id/r4/StructureDefinition/TransportedTime',
                    'valueDateTime' => $this->transportedTime,
                ],
            ];
        }

        return $data;
    }
}
