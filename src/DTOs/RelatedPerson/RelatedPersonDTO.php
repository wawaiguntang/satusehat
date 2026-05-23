<?php

namespace Wawaiguntang\Satusehat\DTOs\RelatedPerson;

/**
 * FHIR R4 - RelatedPerson Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/RelatedPerson
 *
 * Merepresentasikan orang yang memiliki hubungan dengan pasien (contoh: ibu, ayah, wali).
 * Digunakan terutama untuk menghubungkan data bayi dengan NIK ibu.
 *
 * Operasi yang didukung:
 *  - POST  /RelatedPerson                → create
 *  - GET   /RelatedPerson/:id            → by ID
 *  - GET   /RelatedPerson?patient=       → search by patient ID
 *  - GET   /RelatedPerson?identifier=    → search by NIK (format: system|value)
 *
 * Field identifier.system NIK: "https://fhir.kemkes.go.id/id/nik"
 * Field relationship.coding.system: "http://terminology.hl7.org/CodeSystem/v3-RoleCode"
 * Contoh kode relationship: NMTH (natural mother), NFTH (natural father), GRPRN (grandparent)
 * Field communication.language.coding.system: "urn:ietf:bcp:47"
 */
class RelatedPersonDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var bool Apakah relasi aktif */
        public readonly bool $active,

        /**
         * @var array[] Hubungan dengan pasien
         * Struktur: [['code' => string, 'display' => string, 'text' => string|null], ...]
         */
        public readonly array $relationship,

        /** @var string Referensi Patient (field: patient) */
        public readonly string $patientReference,

        /** @var string Gender (male/female/other/unknown) */
        public readonly string $gender,

        /**
         * @var array Identifier (NIK)
         * Struktur: [['use' => string, 'system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik RelatedPerson di SATUSEHAT */
        public readonly ?string $id = null,

        /**
         * @var array[]|null Nama
         * Struktur: [['use' => string, 'text' => string], ...]
         */
        public readonly ?array $name = null,

        /**
         * @var array[]|null Kontak
         * Struktur: [['system' => string, 'value' => string, 'use' => string], ...]
         * system: phone, email, fax, url, sms, other
         */
        public readonly ?array $telecom = null,

        /** @var string|null Tanggal lahir (YYYY-MM-DD) */
        public readonly ?string $birthDate = null,

        /**
         * @var array[]|null Alamat
         * Struktur: [['use' => string, 'line' => string[], 'city' => string, 'postalCode' => string, 'country' => string], ...]
         */
        public readonly ?array $address = null,

        /**
         * @var array[]|null Bahasa komunikasi
         * Struktur: [['code' => string, 'display' => string, 'preferred' => bool], ...]
         * code: BCP-47 (contoh: "id-ID")
         */
        public readonly ?array $communication = null,
    ) {
        $this->resourceType = 'RelatedPerson';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType' => $this->resourceType,
            'meta'         => [
                'profile' => [
                    'https://fhir.kemkes.go.id/r4/StructureDefinition/RelatedPerson',
                ],
            ],
            'identifier'   => $this->identifier,
            'active'       => $this->active,
            'relationship' => array_map(function ($r) {
                $item = [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v3-RoleCode',
                            'code'    => $r['code'],
                            'display' => $r['display'],
                        ],
                    ],
                ];
                if (!empty($r['text'])) {
                    $item['text'] = $r['text'];
                }
                return $item;
            }, $this->relationship),
            'patient' => ['reference' => $this->patientReference],
            'gender'  => $this->gender,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->name !== null) {
            $data['name'] = array_map(fn($n) => [
                'use'  => $n['use'],
                'text' => $n['text'],
            ], $this->name);
        }

        if ($this->telecom !== null) {
            $data['telecom'] = $this->telecom;
        }

        if ($this->birthDate !== null) {
            $data['birthDate'] = $this->birthDate;
        }

        if ($this->address !== null) {
            $data['address'] = $this->address;
        }

        if ($this->communication !== null) {
            $data['communication'] = array_map(fn($c) => [
                'language' => [
                    'coding' => [
                        [
                            'system'  => 'urn:ietf:bcp:47',
                            'code'    => $c['code'],
                            'display' => $c['display'],
                        ],
                    ],
                    'text' => $c['display'],
                ],
                'preferred' => $c['preferred'] ?? false,
            ], $this->communication);
        }

        return $data;
    }
}
