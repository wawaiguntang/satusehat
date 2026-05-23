<?php

namespace Wawaiguntang\Satusehat\DTOs\Immunization;

use Wawaiguntang\Satusehat\Enums\Immunization\ImmunizationStatusEnum;

/**
 * FHIR R4 - Immunization Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Immunization
 *
 * Merepresentasikan pemberian imunisasi/vaksinasi kepada pasien.
 *
 * Operasi yang didukung:
 *  - POST  /Immunization             → create
 *  - GET   /Immunization/:id         → by ID
 *  - GET   /Immunization?patient=    → search by patient ID
 *  - GET   /Immunization?encounter=  → search by encounter ID
 *
 * Kode vaksin menggunakan KFA (http://sys-ids.kemkes.go.id/kfa) dan/atau
 * CVX (http://hl7.org/fhir/sid/cvx).
 * Rute pemberian menggunakan ATC WHO: http://www.whocc.no/atc
 * Catatan: field pasien menggunakan `patient` (bukan `subject`).
 */
class ImmunizationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ImmunizationStatusEnum Status imunisasi */
        public readonly ImmunizationStatusEnum $status,

        /**
         * @var array[] Kode vaksin (multi-coding: KFA + CVX)
         * Struktur: [['system' => string, 'code' => string, 'display' => string], ...]
         */
        public readonly array $vaccineCodeCodings,

        /** @var string Referensi Patient (field: patient) */
        public readonly string $patientReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal imunisasi diberikan (YYYY-MM-DD atau ISO 8601) */
        public readonly string $occurrenceDateTime,

        /** @var string Tanggal dicatat (YYYY-MM-DD) */
        public readonly string $recorded,

        /** @var bool Apakah data berasal dari sumber primer */
        public readonly bool $primarySource,

        /** @var ImmunizationPerformerDTO[] Daftar pelaksana imunisasi */
        public readonly array $performer,

        /** @var string|null ID unik Immunization di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $patientDisplay = null,

        /** @var string|null Referensi Location tempat imunisasi */
        public readonly ?string $locationReference = null,

        /** @var string|null Display nama lokasi */
        public readonly ?string $locationDisplay = null,

        /** @var string|null Nomor lot vaksin */
        public readonly ?string $lotNumber = null,

        /** @var string|null Kode rute pemberian (ATC WHO, contoh: "inj.intramuscular") */
        public readonly ?string $routeCode = null,

        /** @var string|null Display rute pemberian */
        public readonly ?string $routeDisplay = null,

        /** @var float|null Jumlah dosis */
        public readonly ?float $doseQuantityValue = null,

        /** @var string|null Satuan dosis (contoh: "mL") */
        public readonly ?string $doseQuantityUnit = null,

        /**
         * @var array[]|null Alasan imunisasi (ICD-10)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $reasonCode = null,

        /** @var ImmunizationProtocolAppliedDTO[]|null Protokol imunisasi */
        public readonly ?array $protocolApplied = null,
    ) {
        $this->resourceType = 'Immunization';
    }

    public function toArray(): array
    {
        $patient = ['reference' => $this->patientReference];
        if ($this->patientDisplay !== null) {
            $patient['display'] = $this->patientDisplay;
        }

        $data = [
            'resourceType'      => $this->resourceType,
            'status'            => $this->status->value,
            'vaccineCode'       => [
                'coding' => $this->vaccineCodeCodings,
            ],
            'patient'           => $patient,
            'encounter'         => ['reference' => $this->encounterReference],
            'occurrenceDateTime' => $this->occurrenceDateTime,
            'recorded'          => $this->recorded,
            'primarySource'     => $this->primarySource,
            'performer'         => array_map(fn($p) => $p->toArray(), $this->performer),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->locationReference !== null) {
            $location = ['reference' => $this->locationReference];
            if ($this->locationDisplay !== null) {
                $location['display'] = $this->locationDisplay;
            }
            $data['location'] = $location;
        }

        if ($this->lotNumber !== null) {
            $data['lotNumber'] = $this->lotNumber;
        }

        if ($this->routeCode !== null) {
            $data['route'] = [
                'coding' => [
                    [
                        'system'  => 'http://www.whocc.no/atc',
                        'code'    => $this->routeCode,
                        'display' => $this->routeDisplay ?? $this->routeCode,
                    ],
                ],
            ];
        }

        if ($this->doseQuantityValue !== null) {
            $data['doseQuantity'] = [
                'value'  => $this->doseQuantityValue,
                'unit'   => $this->doseQuantityUnit,
                'system' => 'http://unitsofmeasure.org',
                'code'   => $this->doseQuantityUnit,
            ];
        }

        if ($this->reasonCode !== null) {
            $data['reasonCode'] = array_map(fn($r) => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $r['code'],
                        'display' => $r['display'],
                    ],
                ],
            ], $this->reasonCode);
        }

        if ($this->protocolApplied !== null) {
            $data['protocolApplied'] = array_map(fn($p) => $p->toArray(), $this->protocolApplied);
        }

        return $data;
    }
}
