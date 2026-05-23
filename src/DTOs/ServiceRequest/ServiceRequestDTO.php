<?php

namespace Wawaiguntang\Satusehat\DTOs\ServiceRequest;

use Wawaiguntang\Satusehat\Enums\ServiceRequest\ServiceRequestIntentEnum;
use Wawaiguntang\Satusehat\Enums\ServiceRequest\ServiceRequestStatusEnum;
use Wawaiguntang\Satusehat\Shared\Enums\RequestPriorityEnum;

/**
 * FHIR R4 - ServiceRequest Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceRequest
 *
 * Merepresentasikan permintaan layanan/pemeriksaan (lab, radiologi, rujukan, dll.).
 *
 * Operasi yang didukung:
 *  - POST  /ServiceRequest             → create
 *  - GET   /ServiceRequest/:id         → by ID
 *  - GET   /ServiceRequest?subject=    → search by patient ID
 *  - GET   /ServiceRequest?encounter=  → search by encounter ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/servicerequest/{Org_id}"
 * Kode category menggunakan SNOMED CT: http://snomed.info/sct
 * Kode pemeriksaan menggunakan LOINC: http://loinc.org
 */
class ServiceRequestDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ServiceRequestStatusEnum Status permintaan */
        public readonly ServiceRequestStatusEnum $status,

        /** @var ServiceRequestIntentEnum Intent permintaan */
        public readonly ServiceRequestIntentEnum $intent,

        /** @var RequestPriorityEnum Prioritas permintaan */
        public readonly RequestPriorityEnum $priority,

        /** @var string Kode SNOMED CT kategori layanan */
        public readonly string $categoryCode,

        /** @var string Display kategori */
        public readonly string $categoryDisplay,

        /** @var string Kode LOINC jenis pemeriksaan */
        public readonly string $loincCode,

        /** @var string Display jenis pemeriksaan */
        public readonly string $loincDisplay,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Datetime kejadian/pelaksanaan (ISO 8601) */
        public readonly string $occurrenceDateTime,

        /** @var string Datetime dibuat (ISO 8601) */
        public readonly string $authoredOn,

        /** @var string Referensi Practitioner peminta */
        public readonly string $requesterReference,

        /**
         * @var array Identifier
         * Struktur: [['system' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik ServiceRequest di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Display encounter */
        public readonly ?string $encounterDisplay = null,

        /** @var string|null Display peminta */
        public readonly ?string $requesterDisplay = null,

        /** @var string|null Teks kode pemeriksaan */
        public readonly ?string $codeText = null,

        /**
         * @var array[]|null Daftar pelaksana
         * Struktur: [['reference' => string, 'display' => string|null], ...]
         */
        public readonly ?array $performer = null,

        /**
         * @var array[]|null Alasan permintaan
         * Struktur: [['text' => string] | ['code' => string, 'display' => string], ...]
         */
        public readonly ?array $reasonCode = null,
    ) {
        $this->resourceType = 'ServiceRequest';
    }

    public function toArray(): array
    {
        $encounter = ['reference' => $this->encounterReference];
        if ($this->encounterDisplay !== null) {
            $encounter['display'] = $this->encounterDisplay;
        }

        $requester = ['reference' => $this->requesterReference];
        if ($this->requesterDisplay !== null) {
            $requester['display'] = $this->requesterDisplay;
        }

        $code = [
            'coding' => [
                [
                    'system'  => 'http://loinc.org',
                    'code'    => $this->loincCode,
                    'display' => $this->loincDisplay,
                ],
            ],
        ];
        if ($this->codeText !== null) {
            $code['text'] = $this->codeText;
        }

        $data = [
            'resourceType'      => $this->resourceType,
            'identifier'        => $this->identifier,
            'status'            => $this->status->value,
            'intent'            => $this->intent->value,
            'priority'          => $this->priority->value,
            'category'          => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://snomed.info/sct',
                            'code'    => $this->categoryCode,
                            'display' => $this->categoryDisplay,
                        ],
                    ],
                ],
            ],
            'code'              => $code,
            'subject'           => ['reference' => $this->subjectReference],
            'encounter'         => $encounter,
            'occurrenceDateTime' => $this->occurrenceDateTime,
            'authoredOn'        => $this->authoredOn,
            'requester'         => $requester,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->performer !== null) {
            $data['performer'] = array_map(function ($p) {
                $item = ['reference' => $p['reference']];
                if (!empty($p['display'])) {
                    $item['display'] = $p['display'];
                }
                return $item;
            }, $this->performer);
        }

        if ($this->reasonCode !== null) {
            $data['reasonCode'] = array_map(function ($r) {
                if (isset($r['text'])) {
                    return ['text' => $r['text']];
                }
                return [
                    'coding' => [
                        [
                            'system'  => 'http://hl7.org/fhir/sid/icd-10',
                            'code'    => $r['code'],
                            'display' => $r['display'],
                        ],
                    ],
                ];
            }, $this->reasonCode);
        }

        return $data;
    }
}
