<?php

namespace Wawaiguntang\Satusehat\DTOs\ImagingStudy;

use Wawaiguntang\Satusehat\Enums\ImagingStudy\ImagingStudyStatusEnum;

/**
 * FHIR R4 - ImagingStudy Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/ImagingStudy
 *
 * Merepresentasikan studi pencitraan medis (radiologi) berbasis DICOM.
 *
 * Operasi yang didukung:
 *  - POST  /ImagingStudy          → create
 *  - GET   /ImagingStudy/:id      → by ID
 *  - GET   /ImagingStudy?subject= → search by patient ID
 *
 * Identifier menggunakan 2 sistem:
 *  - ACSN: http://sys-ids.kemkes.go.id/acsn/{Org_id} (Accession Number)
 *  - DICOM UID: urn:dicom:uid
 *
 * Modalitas menggunakan DICOM DCM: http://dicom.nema.org/resources/ontology/DCM
 * numberOfSeries dan numberOfInstances dihitung otomatis dari series[].
 */
class ImagingStudyDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ImagingStudyStatusEnum Status studi */
        public readonly ImagingStudyStatusEnum $status,

        /** @var string[] Kode modalitas DICOM (contoh: ["OP", "CT"]) */
        public readonly array $modalityCodes,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Waktu mulai studi (ISO 8601 + timezone) */
        public readonly string $started,

        /** @var ImagingStudySeriesDTO[] Daftar seri studi */
        public readonly array $series,

        /**
         * @var array Identifier studi
         * Struktur: [['use' => string, 'system' => string, 'value' => string, 'type' => array|null], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik ImagingStudy di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string[]|null Referensi ServiceRequest */
        public readonly ?array $basedOnReferences = null,
    ) {
        $this->resourceType = 'ImagingStudy';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'      => $this->resourceType,
            'identifier'        => $this->identifier,
            'status'            => $this->status->value,
            'modality'          => array_map(fn($code) => [
                'system' => 'http://dicom.nema.org/resources/ontology/DCM',
                'code'   => $code,
            ], $this->modalityCodes),
            'subject'           => ['reference' => $this->subjectReference],
            'started'           => $this->started,
            'numberOfSeries'    => count($this->series),
            'numberOfInstances' => array_sum(
                array_map(fn($s) => count($s->instance), $this->series)
            ),
            'series'            => array_map(fn($s) => $s->toArray(), $this->series),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->basedOnReferences !== null) {
            $data['basedOn'] = array_map(fn($r) => ['reference' => $r], $this->basedOnReferences);
        }

        return $data;
    }
}
